<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PakasirPaymentStatusService
{
    public function __construct(private readonly PakasirService $pakasir)
    {
    }

    public function refresh(Order $order): Order
    {
        if (!$order->pakasir_txn_id || $order->status !== 'pending') {
            return $order->fresh();
        }

        $lock = Cache::lock('pakasir-status-' . $order->id, 8);
        if (!$lock->get()) {
            return $order->fresh();
        }

        try {
            $order->refresh();
            if ($order->status !== 'pending') {
                return $order;
            }

            if ($order->last_status_checked_at && $order->last_status_checked_at->gt(now()->subSeconds(4))) {
                return $order;
            }

            // Record the attempt before the HTTP request to enforce Pakasir's per-transaction rate limit.
            $order->update(['last_status_checked_at' => now()]);
            $transaction = $this->pakasir->transactionStatus($order);

            if (($transaction['order_id'] ?? null) !== $order->order_id
                || (int) ($transaction['amount'] ?? 0) !== (int) $order->amount) {
                Log::warning('Pakasir transaction status did not match local order', ['order_id' => $order->order_id]);
                return $order->fresh();
            }

            if (array_key_exists('is_sandbox', $transaction)
                && filter_var($transaction['is_sandbox'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== (bool) config('services.pakasir.is_sandbox')) {
                Log::warning('Pakasir transaction mode did not match application configuration', ['order_id' => $order->order_id]);
                return $order->fresh();
            }

            $status = $transaction['status'];
            if (!in_array($status, ['completed', 'canceled'], true)) {
                return $order->fresh();
            }

            DB::transaction(function () use ($order, $transaction, $status) {
                $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
                $booking = Peminjaman::whereKey($lockedOrder->peminjaman_id)->lockForUpdate()->firstOrFail();

                if ($lockedOrder->status !== 'pending') {
                    return;
                }

                $completedAt = isset($transaction['completed_at'])
                    ? Carbon::parse($transaction['completed_at'])->setTimezone(config('app.timezone'))
                    : now();

                $lockedOrder->update([
                    'status' => $status,
                    'completed_at' => $status === 'completed' ? $completedAt : null,
                ]);

                if ($status === 'completed') {
                    $booking->update(['p_status' => 'DIBAYAR']);
                } elseif ($booking->p_status === 'PENDING') {
                    $booking->update(['p_status' => 'EXPIRED']);
                }
            }, 3);
        } catch (Throwable $exception) {
            Log::warning('Pakasir transaction status check failed', [
                'order_id' => $order->order_id,
                'exception' => $exception->getMessage(),
            ]);
        } finally {
            $lock->release();
        }

        return $order->fresh();
    }
}
