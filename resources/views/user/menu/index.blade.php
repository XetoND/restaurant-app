@extends('layouts.user')

@section('title', 'Menu Lengkap - Gourmet Palace')

@push('styles')
<style>
    .menu-hero { background: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover; height: 300px; display: flex; align-items: center; text-align: center; position: relative; margin-top: 70px; }
    .menu-hero::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); }
    .menu-hero-content { position: relative; z-index: 1; color: white; width: 100%; padding: 0 20px; }
    .menu-hero h1 { font-size: 3.5rem; margin-bottom: 1rem; font-weight: 700; letter-spacing: 1px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); }
    .menu-categories { display: flex; justify-content: center; margin: 2rem 0; flex-wrap: wrap; gap: 10px; }
    .category-btn { padding: 10px 20px; background: transparent; color: var(--secondary); border: 1px solid var(--accent); border-radius: 30px; cursor: pointer; transition: all 0.3s ease; font-weight: 500; }
    .category-btn.active, .category-btn:hover { background: var(--accent); color: var(--secondary); }
    .menu-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; padding: 2rem 0; }
    .menu-item { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; transition: opacity 0.4s ease, transform 0.4s ease; }
    .menu-item.hide { transform: scale(0.9); opacity: 0; display: none; }
    .menu-item:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); }
    .menu-item-img { height: 200px; overflow: hidden; }
    .menu-item-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .menu-item:hover .menu-item-img img { transform: scale(1.05); }
    .menu-item-content { padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1; }
    .menu-item-title { font-size: 1.3rem; margin-bottom: 0.5rem; color: var(--secondary); font-weight: 700; }
    .menu-item-desc { color: var(--text-light); margin-bottom: 1rem; font-size: 0.9rem; line-height: 1.6; flex-grow: 1; }
    .menu-item-meta { display: flex; justify-content: space-between; align-items: center; margin-top: auto; }
    .menu-item-price { font-size: 1.2rem; font-weight: 700; color: var(--accent); }
    .menu-item-btn { background: var(--secondary); color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; transition: all 0.3s ease; font-weight: 500; }
    .menu-item-btn:hover { background: var(--accent); color: var(--secondary); }
</style>
@endpush

@section('content')
    <section class="menu-hero">
        <div class="menu-hero-content">
            <h1>Menu Lengkap Kami</h1>
        </div>
    </section>

    <div class="container">
        <div class="menu-categories">
            <button class="category-btn active" data-filter="all">Semua Menu</button>
            <button class="category-btn" data-filter="Makanan">Makanan</button>
            <button class="category-btn" data-filter="Minuman">Minuman</button>
        </div>

        <div class="menu-container">
            @forelse ($menuItems as $item)
                <div class="menu-item item-modal-trigger" 
                    data-category="{{ $item->category }}"
                    data-id="{{ $item->id }}"
                    data-name="{{ $item->name }}"
                    data-price="{{ $item->price }}"
                    data-description="{{ $item->description }}"
                    data-image="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/400x250.png?text=Gourmet+Palace' }}">
                    
                    <div class="menu-item-img">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/400x250.png?text=Gourmet+Palace' }}" alt="{{ $item->name }}">
                    </div>
                    <div class="menu-item-content">
                        <span class="menu-item-category">{{ $item->category }}</span>
                        <h3 class="menu-item-title">{{ $item->name }}</h3>
                        <p class="menu-item-desc">{{ Str::limit($item->description, 80) }}</p>
                        <div class="menu-item-meta">
                            <span class="menu-item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            <button type="button" class="menu-item-btn">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center">
                    <p>Belum ada menu yang tersedia. Silakan cek kembali nanti.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
{{-- Script untuk filter kategori --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.category-btn');
    const menuItems = document.querySelectorAll('.menu-item');

    if (filterButtons.length === 0 || menuItems.length === 0) {
        return;
    }

    filterButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.stopPropagation();

            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const filterValue = this.getAttribute('data-filter');

            menuItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                if (filterValue === 'all' || itemCategory === filterValue) {
                    item.style.display = 'flex';
                    setTimeout(() => {
                        item.classList.remove('hide');
                    }, 10);
                } else {
                    item.classList.add('hide');
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 400); 
                }
            });
        });
    });
});
</script>
@endpush