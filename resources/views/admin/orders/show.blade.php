@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order->invoice_number)

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Pesanan: {{ $order->invoice_number }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Item yang Dipesan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->menuItem->name }}</td>
                                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Subtotal:</th>
                                    <th class="text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Pajak (12%):</th>
                                    <th class="text-right">Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right font-weight-bold h5">Grand Total:</th>
                                    <th class="text-right font-weight-bold h5">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Info & Aksi</h6>
                </div>
                <div class="card-body">
                    <h5>Informasi Pelanggan</h5>
                    <p><strong>Nama:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d F Y, H:i') }}</p>
                    <hr>
                    <h5>Update Status Pesanan</h5>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="status">Status Saat Ini: 
                                <span class="badge badge-lg 
                                    @if($order->status == 'pending') badge-warning 
                                    @elseif($order->status == 'processing') badge-info
                                    @elseif($order->status == 'completed') badge-success 
                                    @else badge-danger 
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection