<?php

use Illuminate\Support\Facades\Route;

// Import semua controller yang dibutuhkan
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MenuItemController as AdminMenuItemController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/*
|--------------------------------------------------------------------------
| Rute Web Aplikasi Restoran
|--------------------------------------------------------------------------
*/

// == RUTE PUBLIK (Dapat diakses semua orang) ==
Route::get('/', function () {
    return view('home'); // Halaman utama (landing page)
})->name('home');

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index'); // Halaman untuk menampilkan semua menu


// == RUTE PENGGUNA TERAUTENTIKASI ==
Route::middleware('auth')->group(function () {

    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Keranjang Belanja
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::patch('/update/{cartItem}', [CartController::class, 'update'])->name('update');
        Route::delete('/destroy/{cartItem}', [CartController::class, 'destroy'])->name('destroy');
        Route::get('/data', [CartController::class, 'getCartData'])->name('data'); // API
    });

    // Proses Checkout dan Riwayat Pesanan
    Route::post('/checkout', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});


// == RUTE ADMIN ==
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dasbor Admin (opsional, bisa ditambahkan nanti)
    // Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Menu
    Route::resource('menu-items', AdminMenuItemController::class);

    // Manajemen Pesanan
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
});


// Rute autentikasi bawaan Laravel
require __DIR__.'/auth.php';