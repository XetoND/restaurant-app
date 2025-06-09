{{-- resources/views/admin/menu-items/edit.blade.php --}}

@extends('layouts.admin')

@section('title', 'Edit Menu: ' . $menuItem->name)

@section('content')
<div class="container">
    <h2>Edit Menu: {{ $menuItem->name }}</h2>

    <form action="{{ route('admin.menu-items.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">
        @csrf {{-- Wajib untuk keamanan form --}}
        @method('PUT') {{-- Wajib untuk update --}}

        <div class="form-group">
            <input type="text" id="name" name="name" placeholder="Nama Menu" value="{{ old('name', $menuItem->name) }}" class="@error('name') is-invalid @enderror">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <input type="number" step="0.01" id="price" name="price" placeholder="Harga" value="{{ old('price', $menuItem->price) }}" class="@error('price') is-invalid @enderror">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            {{-- Category / Kategori, jika kamu punya kolom ini di database --}}
            {{-- <input type="text" id="category" name="category" placeholder="Kategori (makanan/minuman)" value="{{ old('category', $menuItem->category) }}" class="@error('category') is-invalid @enderror"> --}}
            {{-- @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror --}}

            <input type="file" id="image" name="image" class="@error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if($menuItem->image)
            <div class="mb-3">
                <small class="form-text text-muted d-block mt-2">Gambar saat ini:</small>
                <img src="{{ asset('storage/' . $menuItem->image) }}" alt="Current Menu Image" width="150" class="img-thumbnail mt-1">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                    <label class="form-check-label" for="remove_image">
                        Hapus gambar ini
                    </label>
                </div>
            </div>
        @endif

        <div class="form-group">
            <textarea id="description" name="description" placeholder="Deskripsi" rows="3" class="@error('description') is-invalid @enderror">{{ old('description', $menuItem->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-check">
            <input type="checkbox" id="available" name="available" value="1" {{ old('available', $menuItem->available) ? 'checked' : '' }} class="form-check-input">
            <label class="form-check-label" for="available">Tersedia untuk umum</label>
            @error('available')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn">Perbarui Menu</button>
        <a href="{{ route('admin.menu-items.index') }}" class="btn" style="background: #6c757d;">Batal</a>
    </form>
</div>
@endsection