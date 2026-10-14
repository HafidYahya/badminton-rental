<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected function createPaymentTransaction(Peminjaman $peminjaman)
    {
        try {
            $response = Http::post(env('PAKASIR_BASE_URL') . '/transactioncreate' . '/' . $peminjaman->p_payment_method, [
                'project'  => env('PAKASIR_PROJECT'),
                'order_id' => (string) $peminjaman->p_id,
                'amount'   => (int) $peminjaman->p_total_harga,
                'api_key'  => env('API_KEY_PAKASIR'),
            ]);
        } catch (\Exception $e) {
            Log::error('Payment transaction create request failed', [
                'order_id'       => $peminjaman->p_id,
                'payment_method' => $peminjaman->p_payment_method,
                'error'          => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error'   => 'Gagal melakukan request ke payment gateway.',
            ];
        }

        $responseData = $response->json();

        if (!isset($responseData['payment'])) {
            return [
                'success' => false,
                'error'   => 'Gagal mendapatkan data pembayaran dari payment gateway.',
            ];
        }

        $payment = $responseData['payment'];
        $peminjaman->update([
            'p_status'         => 'PENDING',
            'p_fee'            => $payment['fee'] ?? 0,
            'p_total_payment'  => $payment['total_payment'] ?? ($peminjaman->p_total_harga + ($payment['fee'] ?? 0)),
            'p_payment_number' => $payment['payment_number'] ?? null,
            'p_expired_at'     => isset($payment['expired_at']) ? $this->parseExpiredAt($payment['expired_at']) : null,
        ]);

        return [
            'success'    => true,
            'peminjaman' => $peminjaman->fresh(),
        ];
    }

    private function parseExpiredAt(string $expiredAt)
    {
        return Carbon::parse($expiredAt)->setTimezone(config('app.timezone'));
    }

    public function payment($id)
    {
        $peminjaman = Peminjaman::find($id);
        if (!$peminjaman || $peminjaman->p_customer_id !== Auth::guard('customer')->id()) {
            return redirect()->route('riwayat.booking', Auth::guard('customer')->id())
                ->with('error', 'Booking tidak ditemukan.');
        }

        // Cek jika sudah kedaluwarsa sebelum diproses
        if ($peminjaman->p_status === 'PENDING' && $peminjaman->p_expired_at && Carbon::now()->greaterThan($peminjaman->p_expired_at)) {
            $peminjaman->update(['p_status' => 'EXPIRED']);
        }

        if ($peminjaman->p_status === 'EXPIRED') {
            return redirect()->route('riwayat.booking', Auth::guard('customer')->id())
                ->with('error', 'Batas waktu pembayaran telah habis. Silakan lakukan pemesanan ulang.');
        }

        if ($peminjaman->p_status === 'DIBAYAR') {
            return redirect()->route('riwayat.booking', Auth::guard('customer')->id())
                ->with('success', 'Pembayaran sudah selesai.');
        }

        $paymentInfo  = null;
        $paymentError = null;

        // Jika belum memiliki QR Code atau data pembayaran dari Pakasir
        if (!$peminjaman->p_payment_number || !$peminjaman->p_expired_at) {
            $result = $this->createPaymentTransaction($peminjaman);
            if (!$result['success']) {
                $paymentError = $result['error'] ?? 'Gagal memproses pembayaran.';
            } else {
                $peminjaman = $result['peminjaman'];
            }
        }

        $paymentData = [
            'payment' => [
                'order_id'            => $peminjaman->p_id,
                'amount'              => $peminjaman->p_total_harga,
                'fee'                 => $peminjaman->p_fee,
                'total_payment'       => $peminjaman->p_total_payment,
                'payment_method'      => $peminjaman->p_payment_method,
                'payment_number'      => $peminjaman->p_payment_number,
                'expired_at'          => $peminjaman->p_expired_at ? $peminjaman->p_expired_at->toIso8601String() : null,
                'expired_at_timestamp'=> $peminjaman->p_expired_at ? $peminjaman->p_expired_at->timestamp * 1000 : null,
            ]
        ];

        return view('pages.customer.payment', compact('paymentData', 'paymentError', 'paymentInfo'));
    }

    public function checkPaymentStatus($id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman || $peminjaman->p_customer_id !== Auth::guard('customer')->id()) {
            return response()->json(['error' => 'Tidak ditemukan.'], 404);
        }

        return response()->json([
            'status'       => $peminjaman->p_status,
            'is_paid'      => $peminjaman->p_status === 'DIBAYAR',
            'redirect_url' => route('riwayat.booking', Auth::guard('customer')->id()),
        ]);
    }

    public function handleWebhook(Request $request)
    {
        Log::info('Webhook Pakasir received:', $request->all());

        $payload = $request->validate([
            'amount'         => 'required|integer',
            'order_id'       => 'required|string',
            'project'        => 'required|string',
            'status'         => 'required|string',
            'payment_method' => 'required|string',
            'completed_at'   => 'required|date',
        ]);

        if ($payload['project'] !== env('PAKASIR_PROJECT')) {
            return response()->json(['error' => 'Project tidak valid.'], 422);
        }

        $peminjaman = Peminjaman::find($payload['order_id']);
        if (!$peminjaman) {
            return response()->json(['error' => 'Booking tidak ditemukan.'], 404);
        }

        if ($payload['amount'] !== (int) $peminjaman->p_total_harga && $payload['amount'] !== (int) $peminjaman->p_total_payment) {
            return response()->json(['error' => 'Amount tidak sesuai dengan transaksi.'], 422);
        }

        $verify = $this->verifyTransactionDetail($payload['order_id'], $payload['amount']);
        if (!$verify['success']) {
            return response()->json(['error' => 'Verifikasi transaksi gagal.', 'detail' => $verify['error']], 422);
        }

        $transaction = $verify['transaction'];
        if (($transaction['status'] ?? null) !== 'completed') {
            return response()->json(['error' => 'Status transaksi belum completed.', 'status' => $transaction['status'] ?? null], 422);
        }

        if (($transaction['order_id'] ?? null) !== $payload['order_id'] || (int) ($transaction['amount'] ?? 0) !== $payload['amount']) {
            return response()->json(['error' => 'Data transaksi tidak cocok dengan payload webhook.'], 422);
        }

        $peminjaman->update([
            'p_status'       => 'DIBAYAR',
            'p_completed_at' => $this->parseExpiredAt($payload['completed_at']),
            'p_total_payment'=> $peminjaman->p_total_payment ?? $payload['amount'],
        ]);

        return response()->json(['success' => true]);
    }

    private function verifyTransactionDetail(string $orderId, int $amount): array
    {
        try {
            $response = Http::get(env('PAKASIR_BASE_URL') . '/transactiondetail', [
                'project'  => env('PAKASIR_PROJECT'),
                'amount'   => $amount,
                'order_id' => $orderId,
                'api_key'  => env('API_KEY_PAKASIR'),
            ]);
        } catch (\Exception $e) {
            Log::error('Verify transaction detail failed', [
                'order_id' => $orderId,
                'amount'   => $amount,
                'error'    => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error'   => 'Gagal menghubungi API verifikasi transaksi.',
            ];
        }

        $responseData = $response->json();
        if (!isset($responseData['transaction'])) {
            return [
                'success' => false,
                'error'   => 'Response verifikasi tidak valid.',
            ];
        }

        return [
            'success'     => true,
            'transaction' => $responseData['transaction'],
        ];
    }
}
