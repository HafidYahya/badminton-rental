<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 80)->unique();
            $table->unsignedBigInteger('peminjaman_id');
            $table->string('pakasir_txn_id', 100)->nullable()->unique();
            $table->string('project_slug', 100);
            $table->string('payment_method', 40);
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('fee')->default(0);
            $table->unsignedBigInteger('total_payment')->default(0);
            $table->string('status', 24)->default('initiating');
            $table->longText('qr_string')->nullable();
            $table->text('payment_link')->nullable();
            $table->string('va_number', 100)->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('last_status_checked_at')->nullable();
            $table->timestamps();

            $table->foreign('peminjaman_id')->references('p_id')->on('peminjaman')->cascadeOnDelete();
            $table->index(['peminjaman_id', 'status']);
            $table->index(['status', 'expires_at']);
        });

        DB::table('peminjaman')->orderBy('p_id')->chunk(200, function ($bookings) {
            foreach ($bookings as $booking) {
                $bookingStatus = strtoupper((string) $booking->p_status);
                $orderStatus = match ($bookingStatus) {
                    'DIBAYAR', 'RUNNING', 'FINISH' => 'completed',
                    'CANCEL', 'EXPIRED' => 'canceled',
                    default => 'legacy',
                };
                $amount = (int) round((float) $booking->p_total_harga);
                $fee = (int) round((float) ($booking->p_fee ?? 0));
                $totalPayment = (int) round((float) ($booking->p_total_payment ?? $amount));

                DB::table('orders')->insert([
                    'order_id' => 'LEGACY-' . $booking->p_id,
                    'peminjaman_id' => $booking->p_id,
                    'pakasir_txn_id' => null,
                    'project_slug' => (string) (config('services.pakasir.slug') ?: 'legacy'),
                    'payment_method' => $booking->p_payment_method ?: 'qris',
                    'amount' => $amount,
                    'fee' => $fee,
                    'total_payment' => max($totalPayment, $amount),
                    'status' => $orderStatus,
                    'qr_string' => null,
                    'payment_link' => null,
                    'va_number' => null,
                    'expires_at' => $booking->p_expired_at,
                    'completed_at' => $booking->p_completed_at,
                    'created_at' => $booking->created_at ?? now(),
                    'updated_at' => $booking->updated_at ?? now(),
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
