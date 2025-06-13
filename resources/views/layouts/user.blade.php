<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gourmet Palace')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* =================================================================
           CSS DASAR (HEADER, FOOTER, DLL)
           ================================================================= */
        :root { --primary: #8b5a2b; --secondary: #1a1a1a; --accent: #c19a6b; --light: #f8f5f2; --dark: #333333; --success: #4caf50; --text: #333333; --text-light: #777777; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Playfair Display', serif; }
        body { background-color: var(--light); color: var(--text); line-height: 1.6; }
        .container { max-width: 1400px; margin: 0 auto; padding: 0 20px; }
        header { background: rgba(26, 26, 26, 0.9); color: white; padding: 1rem 0; position: fixed; width: 100%; top: 0; z-index: 1000; backdrop-filter: blur(10px); border-bottom: 1px solid rgba(193, 154, 107, 0.3); }
        .header-container { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.8rem; font-weight: 700; display: flex; align-items: center; text-decoration: none; color: white; }
        .logo i { color: var(--accent); margin-right: 10px; }
        nav ul { display: flex; list-style: none; align-items: center; }
        nav ul li { margin-left: 1.8rem; }
        nav ul li a { color: white; text-decoration: none; font-weight: 500; transition: color 0.3s ease; }
        nav ul li a:hover { color: var(--accent); }
        .cart-icon { position: relative; }
        .cart-count { position: absolute; top: -8px; right: -8px; background: var(--accent); color: var(--secondary); border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 600; }
        footer { background: var(--secondary); color: white; padding: 5rem 0 2rem; margin-top: 3rem; }
        .footer-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-bottom: 3rem; }
        .footer-col h3 { font-size: 1.3rem; margin-bottom: 1.5rem; }
        .footer-col p { color: #bbb; }
        .footer-bottom { text-align: center; padding-top: 3rem; border-top: 1px solid rgba(255,255,255,0.1); color: #bbb; font-size: 0.9rem; }
        
        /* =================================================================
           CSS MODAL & NOTIFIKASI
           ================================================================= */
        /* Notifikasi 'Tambah ke Keranjang' */
        .cart-notification { position: fixed; bottom: 30px; right: 30px; background: var(--success); color: white; padding: 15px 25px; border-radius: 5px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); transform: translateY(120%); opacity: 0; transition: all 0.5s ease; z-index: 1002; display: flex; align-items: center; }
        .cart-notification.show { transform: translateY(0); opacity: 1; }
        .cart-notification i { margin-right: 10px; }

        /* Modal Detail Item */
        .modal { display: none; position: fixed; z-index: 1001; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6); backdrop-filter: blur(5px); justify-content: center; align-items: center; }
        .modal-content { background-color: #fff; padding: 0; width: 90%; max-width: 800px; border-radius: 8px; position: relative; display: flex; flex-direction: column; overflow: hidden; animation: zoomIn 0.3s ease-out; }
        @media (min-width: 768px) { .modal-content { flex-direction: row; } }
        @keyframes zoomIn { from {transform: scale(0.95); opacity: 0;} to {transform: scale(1); opacity: 1;} }
        .modal-image-container { flex-shrink: 0; width: 100%; }
        @media (min-width: 768px) { .modal-image-container { width: 45%; } }
        .modal-image { width: 100%; height: 250px; object-fit: cover; }
        @media (min-width: 768px) { .modal-image { height: 100%; } }
        .modal-details { padding: 2rem; display: flex; flex-direction: column; width: 100%; }
        .modal-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; }
        .modal-title { font-size: 2rem; font-weight: bold; line-height: 1.2; margin: 0; text-align: left; }
        .modal-close { font-size: 2rem; font-weight: normal; cursor: pointer; color: #aaa; background: none; border: none; padding: 0; line-height: 1; }
        .modal-close:hover { color: #333; }
        .modal-desc { margin-bottom: 1.5rem; color: #555; line-height: 1.6; text-align: left; flex-grow: 1; }
        .modal-price { font-size: 1.75rem; font-weight: bold; color: var(--accent); margin-bottom: 1.5rem; text-align: left; }
        .quantity-controls { display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem; }
        .quantity-controls label { font-weight: 600; color: #333; }
        .quantity-controls input { width: 60px; text-align: center; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem; font-weight: bold; -moz-appearance: textfield; }
        .quantity-controls input::-webkit-outer-spin-button, .quantity-controls input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .quantity-btn { font-size: 1.2rem; cursor: pointer; padding: 5px 12px; background-color: #eee; border: 1px solid #ccc; border-radius: 4px; line-height: 1; }
        .modal-add-btn { background: var(--secondary); color: white; border: none; padding: 12px 20px; border-radius: 5px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1rem; }
        .modal-add-btn:hover { background: var(--accent); color: var(--secondary); }
        
        /* Notifikasi Pop-up Sukses Checkout */
        .toast-popup { position: fixed; bottom: 30px; right: 30px; background-color: #28a745; color: white; padding: 16px 24px; border-radius: 8px; box-shadow: 0 5px 20px rgba(0,0,0,0.25); z-index: 1050; display: flex; align-items: center; gap: 15px; max-width: 420px; opacity: 0; transform: translateY(20px); visibility: hidden; transition: transform 0.4s cubic-bezier(0.215, 0.610, 0.355, 1), opacity 0.4s ease, visibility 0.4s; }
        .toast-popup.show { opacity: 1; transform: translateY(0); visibility: visible; }
        .toast-icon i { font-size: 24px; }
        .toast-content { flex-grow: 1; }
        .toast-content .toast-title { font-weight: bold; margin: 0 0 5px 0; }
        .toast-content .toast-message { margin: 0; font-size: 0.9rem; opacity: 0.9; }
        .toast-close { background: none; border: none; color: white; font-size: 24px; line-height: 1; cursor: pointer; opacity: 0.8; padding: 0 0 0 15px; }
        .toast-close:hover { opacity: 1; }

        /* Style untuk Dropdown Profil */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 5px;
            overflow: hidden; /* Agar border-radius terlihat */
        }

        .profile-dropdown-content a, .profile-dropdown-content button {
            color: var(--secondary);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
            width: 100%;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .profile-dropdown-content a:hover, .profile-dropdown-content button:hover {
            background-color: #f1f1f1;
        }

        .profile-dropdown:hover .profile-dropdown-content {
            display: block;
        }

        .profile-icon {
            cursor: pointer;
        }

        .profile-icon img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--accent);
        }
    </style>
    @stack('styles')
</head>
<body>
    <header id="header">
        <div class="container header-container">
            <a href="{{ route('home') }}" class="logo"><i class="fas fa-utensils"></i><span>Gourmet Palace</span></a>
            <nav>
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('menu.index') }}">Menu</a></li>
                    <li><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>

                    @auth
                        {{-- Tampilan jika pengguna sudah login --}}
                        <li class="cart-icon">
                            <a href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart"></i></a>
                            <span class="cart-count">0</span>
                        </li>

                        {{-- IKON PROFIL DENGAN DROPDOWN BARU --}}
                        <li class="profile-dropdown">
                            <div class="profile-icon">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=c19a6b&color=1a1a1a&bold=true" alt="User Profile">
                            </div>
                            <div class="profile-dropdown-content">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">
                                        <i class="fas fa-sign-out-alt fa-fw mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </li>

                    @else
                        {{-- Tampilan jika pengguna belum login (tamu) --}}
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
    
    <div class="cart-notification" id="cartNotification">
        <i class="fas fa-check-circle"></i>
        <span>Item berhasil ditambahkan!</span>
    </div>
    
    <div id="itemDetailModal" class="modal">
        <div class="modal-content" id="modal-body-content"></div>
    </div>

    @if (session('success'))
        <div id="success-toast" class="toast-popup">
            <div class="toast-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="toast-content">
                <p class="toast-title">Sukses!</p>
                <p class="toast-message">{{ session('success') }}</p>
            </div>
            <button type="button" class="toast-close" onclick="this.parentElement.classList.remove('show')">&times;</button>
        </div>
    @endif

    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <h3>Tentang Kami</h3>
                    <p>Gourmet Palace adalah restoran bintang lima yang menawarkan pengalaman kuliner kelas dunia.</p>
                </div>
                <div class="footer-col">
                    <h3>Jam Operasional</h3>
                    <p>Senin - Jumat: 17:00 - 23:00<br>Sabtu - Minggu: 12:00 - 23:00</p>
                </div>
                <div class="footer-col">
                    <h3>Kontak</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Sudirman No. 88, Jakarta</p>
                    <p><i class="fas fa-phone-alt"></i> (021) 555-1234</p>
                    <p><i class="fas fa-envelope"></i> info@gourmetpalace.id</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Gourmet Palace. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // =================================================================
        // Variabel dan Konstanta
        // =================================================================
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
        const modal = document.getElementById('itemDetailModal');
        const modalBody = document.getElementById('modal-body-content');
        const successToast = document.getElementById('success-toast');

        // =================================================================
        // Fungsi-Fungsi Utama
        // =================================================================
        async function fetchCartCount() {
            if (!isLoggedIn) return;
            try {
                const response = await fetch('{{ route('cart.data') }}');
                const data = await response.json();
                updateCartDisplay(data.totalItems || 0);
            } catch (error) { console.error('Error fetching cart count:', error); }
        }

        function updateCartDisplay(count) {
            const cartCountEl = document.querySelector('.cart-count');
            if (cartCountEl) cartCountEl.textContent = count;
        }

        function showNotification(message) {
            const notification = document.getElementById('cartNotification');
            notification.querySelector('span').textContent = message;
            notification.classList.add('show');
            setTimeout(() => notification.classList.remove('show'), 3000);
        }
        
        function openModal(triggerElement) {
            const item = triggerElement.dataset;
            modalBody.innerHTML = `
                <div class="modal-image-container">
                    <img src="${item.image}" alt="${item.name}" class="modal-image">
                </div>
                <div class="modal-details">
                    <div>
                        <div class="modal-header">
                            <h2 class="modal-title">${item.name}</h2>
                            <button type="button" class="modal-close">&times;</button>
                        </div>
                        <p class="modal-desc">${item.description || 'Tidak ada deskripsi.'}</p>
                    </div>
                    <div class="modal-footer">
                        <p class="modal-price">Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</p>
                        <div class="quantity-controls">
                            <label for="quantity">Jumlah:</label>
                            <button type="button" class="quantity-btn" id="decrease-qty">-</button>
                            <input type="number" id="quantity" value="1" min="1">
                            <button type="button" class="quantity-btn" id="increase-qty">+</button>
                        </div>
                        <button class="modal-add-btn" data-item-id="${item.id}">Tambahkan ke Keranjang</button>
                    </div>
                </div>
            `;
            modal.style.display = 'flex';
        }
        
        function closeModal() {
            modal.style.display = 'none';
            modalBody.innerHTML = '';
        }
        
        // =================================================================
        // Event Listeners
        // =================================================================

        // Listener untuk membuka modal
        document.body.addEventListener('click', function(event) {
            if (event.target.closest('.item-modal-trigger')) {
                openModal(event.target.closest('.item-modal-trigger'));
            }
        });

        // Listener untuk semua aksi di dalam modal (delegasi event)
        modal.addEventListener('click', function(event) {
            const target = event.target;
            const qtyInput = modal.querySelector('#quantity');
            if (!qtyInput) return;

            if (target.matches('.modal-close')) closeModal();
            if (target.id === 'increase-qty') qtyInput.stepUp();
            if (target.id === 'decrease-qty') qtyInput.stepDown();
            
            if (target.matches('.modal-add-btn')) {
                if (!isLoggedIn) { window.location.href = '{{ route('login') }}'; return; }
                
                fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
                    body: JSON.stringify({
                        menu_item_id: target.dataset.itemId,
                        quantity: qtyInput.value,
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        updateCartDisplay(data.totalItems);
                        showNotification(data.message);
                        closeModal();
                    }
                })
                .catch(err => console.error(err));
            }
        });
        
        // Listener untuk validasi input manual di dalam modal
        modal.addEventListener('input', function(event) {
            if (event.target.id === 'quantity') {
                if (event.target.value === '' || parseInt(event.target.value) < 1) {
                    event.target.value = 1;
                }
            }
        });
        
        // Menutup modal jika klik di area luar kontennya
        window.addEventListener('click', (event) => { if (event.target == modal) closeModal(); });

        // Handler untuk notifikasi pop-up sukses
        if (successToast) {
            setTimeout(() => {
                successToast.classList.add('show');
            }, 100);

            setTimeout(() => {
                successToast.classList.remove('show');
            }, 5000);
        }

        // Panggilan awal saat halaman dimuat
        fetchCartCount();
    });
    </script>
</body>
</html>