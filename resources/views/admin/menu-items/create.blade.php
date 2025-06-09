{{-- resources/views/admin/menu-items/create.blade.php --}}

@extends('layouts.admin')

@section('title', 'Tambah Menu Baru')

@section('content')
<div class="container">
    <h2>Tambah Menu Baru</h2>

    <form action="{{ route('admin.menu-items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf {{-- Wajib untuk keamanan form --}}

        <div class="form-group">
            <input type="text" id="name" name="name" placeholder="Nama Menu" value="{{ old('name') }}" class="@error('name') is-invalid @enderror">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <input type="number" step="0.01" id="price" name="price" placeholder="Harga" value="{{ old('price') }}" class="@error('price') is-invalid @enderror">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            {{-- Category / Kategori, jika kamu punya kolom ini di database --}}
            {{-- <input type="text" id="category" name="category" placeholder="Kategori (makanan/minuman)" value="{{ old('category') }}" class="@error('category') is-invalid @enderror"> --}}
            {{-- @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror --}}

            <input type="file" id="image" name="image" class="@error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <textarea id="description" name="description" placeholder="Deskripsi" rows="3" class="@error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-check">
            <input type="checkbox" id="available" name="available" value="1" {{ old('available') ? 'checked' : '' }} class="form-check-input">
            <label class="form-check-label" for="available">Tersedia untuk umum</label>
            @error('available')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn">Simpan Menu</button>
        <a href="{{ route('admin.menu-items.index') }}" class="btn" style="background: #6c757d;">Batal</a> {{-- Tombol batal --}}
    </form>
</div>
@endsection