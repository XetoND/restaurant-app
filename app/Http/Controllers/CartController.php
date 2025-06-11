<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    const PAJAK_RATE = 0.12; // Pajak 12%

    private function getCartDataForResponse($user)
    {
        $cartItems = $user->cartItems()->with('menuItem')->get();
        
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->menuItem->price;
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
    
    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        if ($cartItem->user_id !== Auth::id()) {
            return response()->json(['success' => false], 403);
        }

        $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem->update(['quantity' => $request->quantity]);
        
        $data = $this->getCartDataForResponse(Auth::user());

        return response()->json([
            'success'       => true,
            'subtotal'      => "Rp " . number_format($data['subtotal'], 0, ',', '.'),
            'taxAmount'     => "Rp " . number_format($data['taxAmount'], 0, ',', '.'),
            'grandTotal'    => "Rp " . number_format($data['grandTotal'], 0, ',', '.'),
            'totalItems'    => $data['totalItems']
        ]);
    }

    public function destroy(CartItem $cartItem): JsonResponse
    {
        if ($cartItem->user_id !== Auth::id()) {
            return response()->json(['success' => false], 403);
        }

        $cartItem->delete();
        
        $data = $this->getCartDataForResponse(Auth::user());

        return response()->json([
            'success'       => true,
            'message'       => 'Item dihapus.',
            'grandTotal'    => "Rp " . number_format($data['grandTotal'], 0, ',', '.'),
            'totalItems'    => $data['totalItems']
        ]);
    }

    // Fungsi add dan getCartData tidak perlu banyak berubah, namun kita sesuaikan
    public function add(Request $request): JsonResponse
    {
        // ... (logika method add Anda sebelumnya tetap sama) ...
        $request->validate(['menu_item_id' => 'required|exists:menu_items,id', 'quantity' => 'required|integer|min:1']);
        $user = Auth::user();
        $cartItem = $user->cartItems()->where('menu_item_id', $request->input('menu_item_id'))->first();
        if ($cartItem) {
            $cartItem->increment('quantity', $request->input('quantity'));
        } else {
            CartItem::create(['user_id' => $user->id, 'menu_item_id' => $request->input('menu_item_id'), 'quantity' => $request->input('quantity')]);
        }
        $totalItems = $user->cartItems()->sum('quantity');
        return response()->json(['success' => true, 'message' => 'Item berhasil ditambahkan!', 'totalItems' => $totalItems]);
    }

    public function getCartData(): JsonResponse
    {
        $totalItems = Auth::user() ? Auth::user()->cartItems()->sum('quantity') : 0;
        return response()->json(['totalItems' => $totalItems]);
    }
}