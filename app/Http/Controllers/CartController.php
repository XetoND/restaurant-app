<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\CartItem; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class CartController extends Controller
{
    public function add(Request $request, MenuItem $menuItem): JsonResponse
    {
        $user = Auth::user();

        // Cari item di keranjang user, atau buat baru jika belum ada
        $cartItem = CartItem::updateOrCreate(
            [
                'user_id' => $user->id,
                'menu_item_id' => $menuItem->id,
            ],
            [
                // Jika sudah ada, tambahkan quantity. DB::raw() agar aman dari race condition
                'quantity' => \Illuminate\Support\Facades\DB::raw('quantity + 1')
            ]
        );

        // Hitung total item di keranjang dari database
        $totalItems = $user->cartItems()->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ditambahkan ke keranjang!',
            'totalItems' => $totalItems
        ]);
    }

    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('menuItem')->get();
        dd($cartItems); // Dump data untuk melihat hasilnya
    }
}