<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman checkout dengan ringkasan keranjang.
     */
    public function create()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('menuItem')->get();

        // Jika keranjang kosong, jangan biarkan checkout, redirect ke halaman menu
        if ($cartItems->isEmpty()) {
            return redirect()->route('menu.index')->with('error', 'Keranjang Anda kosong!');
        }

        // Hitung total harga dari item di keranjang
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->menuItem->price;
        });

        // Tampilkan view checkout dan kirim data keranjang
        return view('user.orders.checkout', compact('cartItems', 'totalPrice'));
    }

    /**
     * Memproses dan menyimpan pesanan baru dari halaman checkout.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
        ]);

        $user = Auth::user();
        $cartItems = $user->cartItems()->with('menuItem')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('menu.index')->with('error', 'Tidak bisa checkout, keranjang Anda kosong.');
        }

        // Gunakan transaksi untuk memastikan semua data tersimpan atau tidak sama sekali
        DB::transaction(function () use ($user, $cartItems, $request) {
            // Hitung ulang total harga di sisi server untuk keamanan
            $totalPrice = $cartItems->sum(function ($item) {
                return $item->quantity * $item->menuItem->price;
            });

            // 1. Buat data pesanan baru di tabel 'orders'
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending', // Status awal pesanan
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
            ]);

            // 2. Pindahkan setiap item dari keranjang ke tabel 'order_items'
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $cartItem->menu_item_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->menuItem->price, // Simpan harga saat itu
                ]);
            }

            // 3. Setelah berhasil, kosongkan keranjang pengguna
            $user->cartItems()->delete();
        });

        // Arahkan ke halaman sukses dengan pesan
        return redirect()->route('order.success')->with('success', 'Pesanan Anda berhasil dibuat!');
    }

    /**
     * Menampilkan halaman konfirmasi bahwa pesanan berhasil.
     */
    public function success()
    {
        // Pastikan halaman ini hanya bisa diakses setelah berhasil membuat pesanan
        if (!session('success')) {
            return redirect()->route('menu.index');
        }
        return view('user.orders.success');
    }
}