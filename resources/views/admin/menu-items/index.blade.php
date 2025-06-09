{{-- resources/views/admin/menu-items/index.blade.php --}}

@extends('layouts.admin')

@section('title', 'Manajemen Menu') {{-- Menggunakan section title dari layout --}}

@section('content')
<div class="container">
    {{-- Hapus bagian "Tambah / Edit Menu" dari sini, karena akan ada di halaman create/edit terpisah --}}

    <h2>Daftar Menu</h2>

    {{-- Tombol "Tambah Menu Baru" --}}
    <a href="{{ route('admin.menu-items.create') }}" class="btn btn-primary mb-3">Tambah Menu Baru</a>

    {{-- Pesan sukses/error dari session --}}
    {{-- @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif --}}

    <table id="menuTable">
      <thead>
        <tr>
          <th>Gambar</th> {{-- Tambahkan kolom gambar --}}
          <th>Nama</th>
          <th>Harga</th>
          <th>Deskripsi</th>
          <th>Tersedia</th> {{-- Tambahkan kolom ketersediaan --}}
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        {{-- Data menu akan muncul di sini dari database --}}
        @forelse($menuItems as $item)
        <tr>
            <td>
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" width="100" style="max-height: 80px; object-fit: cover;">
                @else
                    <small>Tidak ada gambar</small>
                @endif
            </td>
            <td>{{ $item->name }}</td>
            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
            <td>{{ $item->description }}</td>
            <td>
                @if($item->available)
                    <span style="color: green;">Tersedia</span>
                @else
                    <span style="color: red;">Tidak Tersedia</span>
                @endif
            </td>
            <td class="actions">
                <a href="{{ route('admin.menu-items.edit', $item->id) }}" class="btn edit">Edit</a>
                <form action="{{ route('admin.menu-items.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn delete" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Belum ada menu yang ditambahkan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
</div>

@endsection