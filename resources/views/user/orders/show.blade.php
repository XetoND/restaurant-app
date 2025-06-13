@extends('layouts.user')

@section('title', 'Detail Pesanan ' . $order->invoice_number)

@push('styles')
<style>
    .order-detail-container { padding-top: 120px; max-width: 900px; margin: auto; }
    .order-detail-card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 15px rgba(0,0,0,0.08); }
    .detail-header { border-bottom: 2px solid #f0f0f0; padding-bottom: 1rem; margin-bottom: 1.5rem; }
    .detail-header h1 { font-size: 2rem; font-weight: bold; }
    .item-table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; }
    .item-table th, .item-table td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
    .item-table th { background-color: #f9f9f9; font-weight: 600; }
    .item-table img { width: 60px; height: 60px; object-fit: cover; border-radius: 5px; margin-right: 1rem; }
    .order-summary-box { border-top: 2px solid #f0f0f0; padding-top: 1.5rem; margin-top: 1.5rem; text-align: right; }
</style>
@endpush

@section('content')
<div class="container order-detail-container">
    <div class="order-detail-card">
        <div class="detail-header">
            <h1>Detail Pesanan</h1>
            <p><strong>Invoice:</strong> {{ $order->invoice_number }}</p>
            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d F Y, H:i') }}</p>
            <p><strong>Status:</strong> <span style="text-transform: capitalize; font-weight: bold;">{{ $order->status }}</span></p>
        </div>

        <h3>Item yang Dipesan</h3>
        <table class="item-table">
            <thead>
                <tr>
                    <th colspan="2">Menu</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td style="width: 80px;">
                        <img src="{{ $item->menuItem->image ? asset('storage/' . $item->menuItem->image) : 'https://via.placeholder.com/100' }}" alt="{{ $item->menuItem->name }}">
                    </td>
                    <td>{{ $item->menuItem->name }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="order-summary-box">
            <p><strong>Subtotal:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            <p><strong>Pajak (12%):</strong> Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</p>
            <h3 style="font-size: 1.5rem; font-weight: bold; margin-top: 0.5rem;">Grand Total: Rp {{ number_format($order->grand_total, 0, ',', '.') }}</h3>
        </div>
        
        <div style="margin-top: 2rem; text-align: center;">
            <a href="{{ route('orders.index') }}" style="text-decoration: none; color: var(--primary); font-weight: 600;">&larr; Kembali ke Riwayat Pesanan</a>
        </div>
    </div>
</div>
@endsection