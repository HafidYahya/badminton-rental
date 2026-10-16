<?php

use Illuminate\Foundation\Inspiring;
use App\Models\Order;
use App\Services\PakasirPaymentStatusService;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('pakasir:poll-pending-orders', function (PakasirPaymentStatusService $statusSync) {
    $orders = Order::where('status', 'pending')
        ->whereNotNull('pakasir_txn_id')
        ->where(function ($query) {
            $query->whereNull('last_status_checked_at')
                ->orWhere('last_status_checked_at', '<=', now()->subSeconds(4));
        })
        ->orderBy('id')
        ->limit(100)
        ->get();

    foreach ($orders as $order) {
        $statusSync->refresh($order);
    }

    $this->info('Checked ' . $orders->count() . ' pending Pakasir orders.');
})->purpose('Poll Pakasir status for pending orders');
