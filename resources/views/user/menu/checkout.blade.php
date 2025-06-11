@extends('layouts.user')

@section('title', 'Checkout')

@push('styles')
<style>
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
    .form-group input, .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
    }
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    @media (min-width: 768px) {
        .checkout-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    .order-summary {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid #eee;
    }
    .checkout-btn {
        display: block;
        width: 100%;
        padding: 1rem;
        background: #28a745;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        margin-top: 1rem;
        cursor: pointer;
        border: none;
    }
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 120px; max-width: 900px;">
    <h1 style="font-size: 2.5rem; font-weight: bold; text-align: center; margin-bottom: 2.5rem;">Checkout</h1>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="checkout-grid">

            <div>
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">Data Pengiriman</h3>
                <div class="form-group">
                    <label for="customer_name">Nama Penerima</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ auth()->user()->name }}" required>
                </div>
                <div class="form-group">
                    <label for="customer_phone">Nomor Telepon</label>
                    <input type="tel" name="customer_phone" id="customer_phone" required>
                </div>
                <div class="form-group">
                    <label for="customer_address">Alamat Lengkap</label>
                    <textarea name="customer_address" id="customer_address" rows="4" required></textarea>
                </div>
            </div>

            <div class="order-summary">
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">Ringkasan Pesanan</h3>
                @foreach($cartItems as $item)
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span>{{ $item->menuItem->name }} (x{{ $item->quantity }})</span>
                        <span>Rp {{ number_format($item->quantity * $item->menuItem->price, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <hr style="margin: 1rem 0;">
                <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.2rem;">
                    <span>Total</span>
                    <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
                <button type="submit" class="checkout-btn">Buat Pesanan</button>
            </div>
        </div>
    </form>
</div>
@endsection