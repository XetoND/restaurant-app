@extends('layouts.user')

@section('title', 'Riwayat Pesanan Saya')

@push('styles')
<style>
    .orders-container {
        padding-top: 120px;
        max-width: 1000px;
        margin: auto;
    }
    .order-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        border: 1px solid #eee;
        transition: box-shadow 0.3s ease;
    }
    .order-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .order-header h2 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
    }
    .order-status {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: capitalize;
        color: #fff;
    }
    .order-status.pending { background-color: #ffc107; color: #333; }
    .order-status.processing { background-color: #17a2b8; }
    .order-status.completed { background-color: #28a745; }
    .order-status.cancelled { background-color: #dc3545; }
    .order-details-link {
        display: inline-block;
        margin-top: 1rem;
        text-decoration: none;
        color: var(--primary);
        font-weight: 600;
    }
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }
</style>
@endpush

@section('content')
<div class="container orders-container">
    <h1 style="font-size: 2.5rem; font-weight: bold; text-align: center; margin-bottom: 2.5rem;">Riwayat Pesanan Anda</h1>

    @if($orders->isEmpty())
        <div style="text-align: center; padding: 3rem; background: #fff; border-radius: 8px;">
            <p style="font-size: 1.2rem; margin-bottom: 1.5rem;">Anda belum memiliki riwayat pesanan.</p>
            <a href="{{ route('menu.index') }}" class="checkout-btn" style="background: var(--primary); display: inline-block; width: auto; color: white; text-decoration: none;">Mulai Memesan</a>
        </div>
    @else
        @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <h2>Invoice: {{ $order->invoice_number }}</h2>
                    <span class="order-status {{ $order->status }}">{{ $order->status }}</span>
                </div>
                <div class="order-body">
                    <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d F Y, H:i') }}</p>
                    <p><strong>Total Pesanan:</strong> Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                    <p><strong>Jumlah Item:</strong> {{ $order->items->sum('quantity') }}</p>
                    <a href="{{ route('orders.show', $order) }}" class="order-details-link">Lihat Detail Pesanan &rarr;</a>
                </div>
            </div>
        @endforeach
        
        <div class="pagination">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection