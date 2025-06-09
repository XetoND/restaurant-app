<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\MenuController;


// Jadikan halaman menu sebagai halaman utama (home)
Route::get('/', [MenuController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Mengalihkan rute /menu lama ke halaman utama
Route::redirect('/menu', '/')->name('menu.index');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('menu-items', App\Http\Controllers\Admin\MenuItemController::class);
});

require __DIR__.'/auth.php';