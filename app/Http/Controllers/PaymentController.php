<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Peminjaman;
use App\Services\PakasirService;
use App\Services\PakasirPaymentStatusService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PakasirService $pakasir,
        private readonly PakasirPaymentStatusService $statusSync,
    ) {
    }

    public function payment($id)
    {
        $customerId = Auth::guard('customer')->id();
        $booking = Peminjaman::with('latestOrder')
            ->where('p_id', $id)
            ->where('p_customer_id', $customerId)
            ->first();

        if (!$booking) {
            return redirect()->route('riwayat.booking', $customerId)->with('error', 'Booking tidak ditemukan.');
        }

        if (in_array($booking->p_status, ['EXPIRED', 'CANCEL'])) {
            return redirect()->route('riwayat.booking', $customerId)
                ->with('error', 'Pemesanan ini sudah tidak dapat dibayar.');
        }

        if (in_array($booking->p_status, ['DIBAYAR', 'RUNNING', 'FINISH'])) {
            return redirect()->route('riwayat.booking', $customerId)->with('success', 'Pembayaran sudah selesai.');
        }

        $paymentError = null;
        $order = $this->getOrCreateOrder($booking);
        $order = $this->ensureSandboxExpiry($order);

        if ($order->status === 'pending' && $order->expires_at && $order->expires_at->isPast()) {
            $order = $this->refreshTransactionStatus($order);
            $booking->refresh();
            if (in_array($booking->p_status, ['EXPIRED', 'CANCEL'])) {
                return redirect()->route('riwayat.booking', $customerId)
                    ->with('error', 'Batas waktu pembayaran telah habis. Silakan lakukan pemesanan ulang.');
            }
            if (in_array($booking->p_status, ['DIBAYAR', 'RUNNING', 'FINISH'])) {
                return redirect()->route('riwayat.booking', $customerId)->with('success', 'Pembayaran sudah selesai.');
            }
        }

        if ($order->status === 'initiating' || $order->status === 'failed') {
            $createLock = Cache::lock('pakasir-create-' . $order->id, 20);
            if (!$createLock->get()) {
                $paymentError = 'Transaksi sedang diproses. Muat ulang halaman sebentar lagi.';
            } else {
                try {
                    $order->refresh();
                    if ($order->status === 'initiating' || $order->status === 'failed') {
                        $result = $this->pakasir->createTransaction($order);
                        if ($result['success']) {
                            $order = $this->storeGatewayPayment($order, $result['payment']);
                        } else {
                            $paymentError = $result['error'];
                            Log::warning('Pakasir rejected transaction creation', [
                                'order_id' => $order->order_id,
                                'http_status' => $result['http_status'] ?? null,
                                'provider_message' => $result['error'],
                            ]);
                            if (!$result['retryable']) {
                                DB::transaction(function () use ($order) {
                                    Order::whereKey($order->id)->lockForUpdate()->update([
                                        'status' => 'failed',
                                        'updated_at' => now(),
                                    ]);
                                });
                            }
                        }
                    }
                } catch (Throwable $exception) {
                    Log::warning('Pakasir create transaction failed', [
                        'order_id' => $order->order_id,
                        'exception' => $exception->getMessage(),
                    ]);
                    $paymentError = 'Belum dapat membuat transaksi pembayaran. Silakan coba lagi.';
                } finally {
                    $createLock->release();
                }
            }
        }

        $order->refresh();
        $order = $this->ensureSandboxExpiry($order);
        $paymentData = [
            'payment' => [
                'order_id' => $order->order_id,
                'booking_id' => $booking->p_id,
                'amount' => $order->amount,
                'fee' => $order->fee,
                'total_payment' => $order->total_payment,
                'payment_method' => $order->payment_method,
                'payment_number' => $order->qr_string,
                'qr_string' => $order->qr_string,
                'payment_link' => $order->payment_link,
                'va_number' => $order->va_number,
                'status' => $order->status,
                'expired_at' => $order->expires_at?->toIso8601String(),
                'expired_at_timestamp' => $order->expires_at?->timestamp * 1000,
                'is_sandbox' => (bool) $order->is_sandbox,
            ],
        ];

        return view('pages.customer.payment', [
            'paymentData' => $paymentData,
            'paymentError' => $paymentError,
            'paymentInfo' => null,
        ]);
    }

    private function ensureSandboxExpiry(Order $order): Order
    {
        if ($order->status !== 'pending' || !$order->is_sandbox || $order->expires_at) {
            return $order;
        }

        return DB::transaction(function () use ($order) {
            $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
            if ($lockedOrder->status === 'pending' && $lockedOrder->is_sandbox && !$lockedOrder->expires_at) {
                // Sandbox responses may omit expiry; provide a stable local window for UI testing.
                $lockedOrder->update(['expires_at' => now()->addMinutes(15)]);
            }

            return $lockedOrder->fresh();
        }, 3);
    }

    private function getOrCreateOrder(Peminjaman $booking): Order
    {
        return DB::transaction(function () use ($booking) {
            $lockedBooking = Peminjaman::whereKey($booking->p_id)->lockForUpdate()->firstOrFail();
            $order = $lockedBooking->orders()->latest('id')->lockForUpdate()->first();

            if ($order
                && in_array($order->status, ['initiating', 'pending'], true)
                && (bool) $order->is_sandbox !== (bool) config('services.pakasir.is_sandbox')) {
                $order->update(['status' => 'canceled']);
                $order = null;
            }

            if ($order && in_array($order->status, ['initiating', 'pending', 'completed'], true)) {
                return $order;
            }

            $slug = config('services.pakasir.slug');
            if (!$slug) {
                throw new RuntimeException('Konfigurasi proyek Pakasir belum lengkap.');
            }

            return $lockedBooking->orders()->create([
                'order_id' => 'BD-' . Str::upper((string) Str::uuid()),
                'project_slug' => $slug,
                'is_sandbox' => (bool) config('services.pakasir.is_sandbox'),
                'payment_method' => $order?->payment_method ?: 'qris',
                'amount' => (int) round((float) $lockedBooking->p_total_harga),
                'fee' => 0,
                'total_payment' => (int) round((float) $lockedBooking->p_total_harga),
                'status' => 'initiating',
            ]);
        }, 3);
    }

    private function storeGatewayPayment(Order $order, array $payment): Order
    {
        return DB::transaction(function () use ($order, $payment) {
            $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
            $booking = Peminjaman::whereKey($lockedOrder->peminjaman_id)->lockForUpdate()->firstOrFail();

            if ($lockedOrder->status === 'completed') {
                return $lockedOrder;
            }

            $fee = (int) ($payment['fee'] ?? 0);
            $expiresAt = isset($payment['expired_at'])
                ? Carbon::parse($payment['expired_at'])->setTimezone(config('app.timezone'))
                : null;

            $lockedOrder->update([
                'pakasir_txn_id' => $payment['txn_id'],
                'is_sandbox' => array_key_exists('is_sandbox', $payment)
                    ? filter_var($payment['is_sandbox'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                    : (bool) config('services.pakasir.is_sandbox'),
                'payment_method' => $payment['payment_method'] ?? $lockedOrder->payment_method,
                'fee' => $fee,
                'total_payment' => (int) ($payment['total_payment'] ?? ($lockedOrder->amount + $fee)),
                'qr_string' => $payment['qr_string'] ?? null,
                'payment_link' => $payment['payment_link'] ?? null,
                'va_number' => $payment['va_number'] ?? null,
                'expires_at' => $expiresAt,
                'status' => 'pending',
            ]);

            return $lockedOrder->fresh();
        }, 3);
    }

    public function checkPaymentStatus($id)
    {
        $customerId = Auth::guard('customer')->id();
        $booking = Peminjaman::with('latestOrder')
            ->where('p_id', $id)
            ->where('p_customer_id', $customerId)
            ->first();

        if (!$booking) {
            return response()->json(['error' => 'Tidak ditemukan.'], 404);
        }

        if ($booking->latestOrder && $booking->latestOrder->status === 'pending') {
            $this->refreshTransactionStatus($booking->latestOrder);
            $booking->refresh();
        }

        return response()->json([
            'status' => $booking->p_status,
            'order_status' => $booking->latestOrder?->fresh()->status,
            'is_paid' => in_array($booking->p_status, ['DIBAYAR', 'RUNNING', 'FINISH']),
            'redirect_url' => route('riwayat.booking', $customerId),
        ]);
    }

    private function refreshTransactionStatus(Order $order): Order
    {
        return $this->statusSync->refresh($order);
    }
}
