<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;


// Jadikan halaman menu sebagai halaman utama (home)
Route::get('/', [MenuController::class, 'index'])->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute untuk Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/destroy/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    // API untuk mengambil data jumlah keranjang (untuk header)
    Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');

// Rute untuk Proses Pemesanan
    Route::post('/checkout', [OrderController::class, 'store'])->name('order.store')->middleware('auth'); 

// Mengalihkan rute /menu lama ke halaman utama
Route::redirect('/menu', '/')->name('menu.index');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('menu-items', App\Http\Controllers\Admin\MenuItemController::class);
});

require __DIR__.'/auth.php';