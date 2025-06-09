{{-- resources/views/user/menu/index.blade.php --}}

@extends('layouts.app') {{-- Sesuaikan dengan layout user/publik Anda --}}

@section('title', 'Menu Kami - Gourmet Palace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center mb-10 text-gray-800">Menu Lezat Kami</h1>

    @if($menuItems->isEmpty())
        <p class="text-center text-lg text-gray-600">Maaf, belum ada menu yang tersedia saat ini. Silakan cek kembali nanti!</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($menuItems as $item)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-full">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                    @else
                        <img src="{{ asset('images/default-menu-image.png') }}" alt="Gambar Default" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6 flex flex-col justify-between flex-grow">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-2">{{ $item->name }}</h2>
                            <p class="text-gray-600 mb-4 flex-grow">{{ $item->description }}</p>
                        </div>
                        <div class="flex justify-between items-center mt-auto">
                            <span class="text-xl font-bold text-green-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            {{-- Tombol "Tambah ke Keranjang" akan ditambahkan di sini nanti --}}
                            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection