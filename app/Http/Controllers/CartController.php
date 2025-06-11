<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    const PAJAK_RATE = 0.12; // Pajak 12%

    /**
     * Fungsi private untuk mengambil semua data keranjang dan menghitung total.
     * Digunakan oleh beberapa method untuk menghindari duplikasi kode.
     */
    private function getCartDataForResponse($user)
    {
        // Eager load relasi menuItem untuk efisiensi query
        $cartItems = $user->cartItems()->with('menuItem')->get();
        
        $subtotal = $cartItems->sum(function ($item) {
            // Pastikan menuItem ada untuk menghindari error
            if ($item->menuItem) {
                return $item->quantity * $item->menuItem->price;
            }
            return 0;
        });

        $taxAmount = $subtotal * self::PAJAK_RATE;
        $grandTotal = $subtotal + $taxAmount;

        return [
            'cartItems'  => $cartItems,
            'subtotal'   => $subtotal,
            'taxAmount'  => $taxAmount,
            'grandTotal' => $grandTotal,
            'totalItems' => $cartItems->sum('quantity'),
        ];
    }

    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function index()
    {
        $data = $this->getCartDataForResponse(Auth::user());
        return view('user.cart.index', [
            'cartItems'  => $data['cartItems'],
            'subtotal'   => $data['subtotal'],
            'taxAmount'  => $data['taxAmount'],
            'grandTotal' => $data['grandTotal'],
        ]);
    }
    
    /**
     * Mengupdate kuantitas item di keranjang.
     * Ini adalah method yang diperbaiki.
     */
    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        if ($cartItem->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $cartItem->update(['quantity' => $request->quantity]);
        
        // Hitung subtotal untuk item spesifik yang baru diupdate
        $itemSubtotal = $cartItem->quantity * $cartItem->menuItem->price;

        // Hitung ulang semua total untuk keseluruhan keranjang
        $data = $this->getCartDataForResponse(Auth::user());

        // Kembalikan semua data yang dibutuhkan oleh JavaScript
        return response()->json([
            'success'       => true,
            'item_id'       => $cartItem->id, // PENTING: ID item untuk dicari oleh JS
            'item_subtotal' => "Rp " . number_format($itemSubtotal, 0, ',', '.'), // PENTING: Subtotal item spesifik
            'subtotal'      => "Rp " . number_format($data['subtotal'], 0, ',', '.'),
            'taxAmount'     => "Rp " . number_format($data['taxAmount'], 0, ',', '.'),
            'grandTotal'    => "Rp " . number_format($data['grandTotal'], 0, ',', '.'),
            'totalItems'    => $data['totalItems']
        ]);
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function destroy(CartItem $cartItem): JsonResponse
    {
        if ($cartItem->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();
        
        $data = $this->getCartDataForResponse(Auth::user());

        return response()->json([
            'success'       => true,
            'message'       => 'Item dihapus dari keranjang.',
            'subtotal'      => "Rp " . number_format($data['subtotal'], 0, ',', '.'),
            'taxAmount'     => "Rp " . number_format($data['taxAmount'], 0, ',', '.'),
            'grandTotal'    => "Rp " . number_format($data['grandTotal'], 0, ',', '.'),
            'totalItems'    => $data['totalItems'],
            'cart_is_empty' => $data['cartItems']->isEmpty() // Info jika keranjang jadi kosong
        ]);
    }

    /**
     * Menambahkan item ke keranjang.
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity'     => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $cartItem = $user->cartItems()->where('menu_item_id', $request->input('menu_item_id'))->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->input('quantity'));
        } else {
            CartItem::create([
                'user_id'      => $user->id,
                'menu_item_id' => $request->input('menu_item_id'),
                'quantity'     => $request->input('quantity')
            ]);
        }
        
        $totalItems = $user->cartItems()->sum('quantity');
        return response()->json(['success' => true, 'message' => 'Item berhasil ditambahkan!', 'totalItems' => $totalItems]);
    }

    /**
     * Mengambil jumlah total item di keranjang (biasanya untuk ikon di header).
     */
    public function getCartData(): JsonResponse
    {
        $totalItems = Auth::user() ? Auth::user()->cartItems()->sum('quantity') : 0;
        return response()->json(['totalItems' => $totalItems]);
    }
}
