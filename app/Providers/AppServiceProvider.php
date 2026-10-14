<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // View Composer untuk menyuplai data notifikasi ke navbar admin
        \Illuminate\Support\Facades\View::composer('components.navbar', function ($view) {
            // Auto-expire dulu untuk memastikan data notifikasi akurat
            \App\Models\Peminjaman::where('p_status', 'PENDING')
                ->whereNotNull('p_expired_at')
                ->where('p_expired_at', '<=', \Carbon\Carbon::now())
                ->update(['p_status' => 'EXPIRED']);

            $notifCount = \App\Models\Peminjaman::where('p_status', 'DIBAYAR')->count();
            $notifList = \App\Models\Peminjaman::with(['customer', 'lapangan'])
                ->where('p_status', 'DIBAYAR')
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get();

            $view->with(compact('notifCount', 'notifList'));
        });
    }
}
