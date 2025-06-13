<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    const PAJAK_RATE = 0.12; // Pajak 12%

    /**
     * Memproses keranjang menjadi pesanan.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('menuItem')->get();

        // 1. Pastikan keranjang tidak kosong
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // 2. Hitung ulang total di server untuk keamanan
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->menuItem->price);
        $taxAmount = $subtotal * self::PAJAK_RATE;
        $grandTotal = $subtotal + $taxAmount;

        // 3. Gunakan Database Transaction untuk keamanan data
        try {
            DB::beginTransaction();

            // Buat entri di tabel 'orders'
            $order = Order::create([
                'user_id'        => $user->id,
                'invoice_number' => 'INV-' . time() . '-' . $user->id, // Contoh nomor invoice unik
                'total_amount'   => $subtotal,
                'tax_amount'     => $taxAmount,
                'grand_total'    => $grandTotal,
                'status'         => 'pending', // Status awal pesanan
            ]);

            // Pindahkan setiap item dari keranjang ke 'order_items'
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'menu_item_id' => $item->menu_item_id,
                    'quantity'     => $item->quantity,
                    'price'        => $item->menuItem->price, // Simpan harga saat itu
                ]);
            }

            // 4. Kosongkan keranjang belanja pengguna
            $user->cartItems()->delete();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            // Sebaiknya log error ini
            return redirect()->route('cart.index')->with('error', 'Gagal memproses pesanan. Silakan coba lagi.');
        }

        // 5. Arahkan ke halaman sukses
        // Anda bisa membuat halaman "Terima Kasih" atau "Histori Pesanan"
        return redirect()->route('menu.index')->with('success', 'Pesanan Anda berhasil dibuat! Nomor Invoice: ' . $order->invoice_number);
    }

    /**
     * Menampilkan daftar pesanan milik pengguna.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->with('items')->latest()->paginate(10);
        return view('user.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(Order $order)
    {
        // Pastikan pengguna hanya bisa melihat pesanannya sendiri
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Anda tidak diizinkan mengakses halaman ini.');
        }

        // Eager load relasi 'items' dan 'menuItem' di dalam 'items'
        $order->load('items.menuItem');
        
        return view('user.orders.show', compact('order'));
    }
}