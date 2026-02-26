<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;     // Tambahan Wajib
use Illuminate\Support\Facades\Auth;     // Tambahan Wajib
use App\Models\Chat;                     // Tambahan Wajib
use Illuminate\Support\Facades\Schema;   // Tambahan Wajib

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
        // Fix untuk panjang string database di beberapa versi MySQL
        Schema::defaultStringLength(191);

        // LOGIKA AGAR RIWAYAT CHAT MUNCUL DI SIDEBAR (LAYOUTS.APP)
        // app/Providers/AppServiceProvider.php
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                // Ambil folder percakapan (Chat), bukan tiap balon pesan
                // app/Providers/AppServiceProvider.php
                $histories = Chat::where('user_id', Auth::id())
                    ->orderBy('updated_at', 'desc')
                    ->get(); // Ini akan mengambil folder percakapan, bukan balon chat.
                $view->with('histories', $histories);
            }
        });
    }
}