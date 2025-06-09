<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Membuat View Composer untuk view 'layouts.user'
        View::composer('layouts.user', function ($view) {
            $cartCount = 0;
            // Hanya hitung jika user sudah login
            if (Auth::check()) {
                // Hitung total dari kolom 'quantity' di tabel cart_items milik user
                $cartCount = Auth::user()->cartItems()->sum('quantity');
            }

            // Kirim variabel $cartCount ke view 'layouts.user' setiap kali view itu di-render
            $view->with('cartCount', $cartCount);
        });
    }
}