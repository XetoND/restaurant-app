<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan.
     */
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail spesifik dari sebuah pesanan.
     */
    public function show(Order $order)
    {
        // Eager load relasi yang dibutuhkan
        $order->load('user', 'items.menuItem');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Memperbarui status pesanan.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders.show', $order)->with('success', 'Status pesanan berhasil diperbarui.');
    }
}