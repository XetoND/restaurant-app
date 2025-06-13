@extends('layouts.admin')

@section('title', 'Manajemen Menu')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Daftar Menu</h1>
    <p class="mb-4">Berikut adalah daftar semua menu yang tersedia di restoran. Anda dapat menambah, mengubah, atau menghapus menu dari daftar ini.</p>

    <a href="{{ route('admin.menu-items.create') }}" class="btn btn-primary btn-icon-split mb-4">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Menu Baru</span>
    </a>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Menu</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Kategori</th> {{-- <-- PERUBAHAN DI SINI --}}
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menuItems as $item)
                        <tr>
                            <td class="text-center">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="max-width: 80px; height: auto; border-radius: 5px;">
                                @else
                                    <small>Tanpa Gambar</small>
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            
                            <td>{{ $item->category ?? 'Lainnya' }}</td>

                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if($item->available)
                                    <span class="badge badge-success">Tersedia</span>
                                @else
                                    <span class="badge badge-danger">Kosong</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.menu-items.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </a>
                                <form action="{{ route('admin.menu-items.destroy', $item->id) }}" method="POST" style="display:inline-block; margin-left: 5px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            {{-- PERUBAHAN DI SINI: colspan diubah menjadi 7 --}}
                            <td colspan="7" class="text-center">Belum ada menu yang ditambahkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection