@extends('layouts.user')

@section('title', 'Menu Lengkap - Gourmet Palace')

@push('styles')
<style>
    /* SEMUA CSS DARI FILE menu.html DITEMPEL DI SINI */
    :root {
        --primary: #8b5a2b;
        --secondary: #1a1a1a;
        --accent: #c19a6b;
        --light: #f8f5f2;
        --dark: #333333;
        --success: #4caf50;
        --text: #333333;
        --text-light: #777777;
    }
    
    body {
        /* font-family: 'Playfair Display', serif; -> Dihapus karena sudah ada di layout utama */
    }

    /* Hero Section */
    .menu-hero {
        background: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
        height: 300px;
        display: flex;
        align-items: center;
        text-align: center;
        position: relative;
        margin-top: 70px; /* Sesuaikan dengan tinggi header Anda */
    }
    
    .menu-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }
    
    .menu-hero-content {
        position: relative;
        z-index: 1;
        color: white;
        width: 100%;
        padding: 0 20px;
    }
    
    .menu-hero h1 {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    /* Menu Categories */
    .menu-categories {
        display: flex;
        justify-content: center;
        margin: 2rem 0;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .category-btn {
        padding: 10px 20px;
        background: transparent;
        color: var(--secondary);
        border: 1px solid var(--accent);
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .category-btn.active, .category-btn:hover {
        background: var(--accent);
        color: var(--secondary);
    }
    
    /* Menu Grid */
    .menu-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        padding: 2rem 0;
    }
    
    .menu-item {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        display: flex;
        flex-direction: column;
    }
    
    .menu-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }
    
    .menu-item-img {
        height: 200px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }
    
    .menu-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }
    
    .menu-item:hover .menu-item-img img {
        transform: scale(1.1);
    }
    
    .menu-item-content {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1; /* Membuat content mengisi sisa ruang */
    }
    
    .menu-item-title {
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
        color: var(--secondary);
        font-weight: 700;
    }
    
    .menu-item-desc {
        color: var(--text-light);
        margin-bottom: 1rem;
        font-size: 0.9rem;
        line-height: 1.6;
        flex-grow: 1; /* Membuat deskripsi mengisi ruang */
    }
    
    .menu-item-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto; /* Mendorong meta ke bagian bawah */
    }
    
    .menu-item-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--accent);
    }
    
    .menu-item-btn {
        background: var(--secondary);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .menu-item-btn:hover {
        background: var(--accent);
        color: var(--secondary);
    }
</style>
@endpush

@section('content')
    <section class="menu-hero">
        <div class="menu-hero-content">
            <div class="container">
                <h1>Menu Lengkap Kami</h1>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="menu-categories">
            <button class="category-btn active">Semua Menu</button>
            <button class="category-btn">Makanan</button>
            <button class="category-btn">Minuman</button>
            <button class="category-btn">Spesial Chef</button>
        </div>
    </div>

    <div class="container">
        <div class="menu-container" id="menu-container">
            @forelse ($menuItems as $item)
                <div class="menu-item" 
                     data-id="{{ $item->id }}"
                     data-name="{{ $item->name }}"
                     data-price="Rp {{ number_format($item->price, 0, ',', '.') }}"
                     data-description="{{ $item->description }}"
                     data-image="{{ asset('storage/' . $item->image) }}">

                    <div class="menu-item-img">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                    </div>
                    <div class="menu-item-content">
                        <h3 class="menu-item-title">{{ $item->name }}</h3>
                        <p class="menu-item-desc">{{ Str::limit($item->description, 100) }}</p>
                        <div class="menu-item-meta">
                            <span class="menu-item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            <button class="menu-item-btn">Pesan</button>
                        </div>
                    </div>
                </div>
            @empty
                <p>Maaf, belum ada menu yang tersedia saat ini.</p>
            @endforelse
        </div>
    </div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isUserLoggedIn = @auth true @else false @endauth;
    const modal = document.getElementById('itemModal');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDesc = document.getElementById('modalDesc');
    const modalPrice = document.getElementById('modalPrice');
    const modalAddBtn = document.getElementById('modalAddBtn');

    function openModal(itemElement) {
        modalImage.src = itemElement.dataset.image;
        modalTitle.textContent = itemElement.dataset.name;
        modalDesc.textContent = itemElement.dataset.description;
        modalPrice.textContent = itemElement.dataset.price;

        modalAddBtn.onclick = () => {
            addToCart(itemElement.dataset.id);
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        };
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    document.querySelectorAll('.menu-item').forEach(item => {
        const img = item.querySelector('.menu-item-img');
        if (img) {
            img.addEventListener('click', () => openModal(item));
        }
        const btn = item.querySelector('.menu-item-btn');
        if (btn) {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                addToCart(item.dataset.id);
            });
        }
    });

    function addToCart(itemId) {
        // Cek jika user belum login
        if (!isUserLoggedIn) {
            alert('Anda harus login terlebih dahulu untuk menambahkan item ke keranjang.');
            window.location.href = "{{ route('login') }}"; // Arahkan ke halaman login
            return; // Hentikan eksekusi fungsi
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = `/cart/add/${itemId}`; 

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount(data.totalItems);
                showNotification();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menambahkan item.');
        });
    }

    function updateCartCount(count) {
        document.querySelector('.cart-count').textContent = count;
    }

    function showNotification() {
        const notification = document.getElementById('cartNotification');
        if (notification) {
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
    }
});

</script>
@endpush