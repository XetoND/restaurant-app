@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Pesanan</h1>

    <div class="mb-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm {{ request('status') == '' ? 'btn-primary' : 'btn-secondary' }}">Semua</a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-warning' : 'btn-secondary' }}">Pending</a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="btn btn-sm {{ request('status') == 'processing' ? 'btn-info' : 'btn-secondary' }}">Processing</a>
        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="btn btn-sm {{ request('status') == 'completed' ? 'btn-success' : 'btn-secondary' }}">Completed</a>
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="btn btn-sm {{ request('status') == 'cancelled' ? 'btn-danger' : 'btn-secondary' }}">Cancelled</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->invoice_number }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($order->status == 'pending') badge-warning 
                                        @elseif($order->status == 'processing') badge-info
                                        @elseif($order->status == 'completed') badge-success 
                                        @else badge-danger 
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection