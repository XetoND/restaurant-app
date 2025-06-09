<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gourmet Palace')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Anda bisa memindahkan CSS ini ke file CSS terpisah (misal: public/css/user.css) --}}
    <style>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Playfair Display', serif; /* Pastikan font ini terload, mungkin dari Google Fonts */
        }

        body {
            background-color: var(--light);
            color: var(--text);
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background: rgba(26, 26, 26, 0.9);
            color: white;
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(193, 154, 107, 0.3);
            transition: all 0.3s ease;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .logo i {
            color: var(--accent);
            margin-right: 10px;
        }

        nav ul {
            display: flex;
            list-style: none;
            align-items: center;
        }

        nav ul li {
            margin-left: 1.8rem;
            position: relative;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding-bottom: 5px;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }

        nav ul li a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--accent);
            bottom: 0;
            left: 0;
            transition: width 0.3s ease;
        }

        nav ul li a:hover:after {
            width: 100%;
        }

        .cart-icon {
            position: relative;
            margin-left: 1.5rem;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--accent);
            color: var(--secondary);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 2000;
            overflow-y: auto;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 1;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            max-width: 800px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            animation: modalFadeIn 0.3s ease forwards;
        }

        @keyframes modalFadeIn {
            to {
                transform: scale(1);
            }
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--secondary);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: var(--accent);
            color: var(--secondary);
        }

        .modal-img {
            height: 300px;
            overflow: hidden;
        }

        .modal-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--secondary);
        }

        .modal-category {
            display: inline-block;
            background: var(--light);
            color: var(--accent);
            padding: 5px 15px;
            border-radius: 30px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .modal-desc {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .modal-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 1.5rem;
        }

        .modal-add {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
        }

        .modal-add:hover {
            background: var(--accent);
            color: var(--secondary);
        }

        /* Cart Notification */
        .cart-notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--success);
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            display: flex;
            align-items: center;
        }

        .cart-notification.show {
            transform: translateY(0);
            opacity: 1;
        }

        .cart-notification i {
            margin-right: 10px;
        }

        /* Footer */
        footer {
            background: var(--secondary);
            color: white;
            padding: 5rem 0 2rem;
            margin-top: 3rem;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 3rem;
        }

        .footer-col h3 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 10px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .footer-col h3:after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            background: var(--accent);
            bottom: 0;
            left: 0;
        }

        .footer-col p {
            margin-bottom: 1.5rem;
            color: #bbb;
            line-height: 1.7;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
        }

        .footer-links a:hover {
            color: var(--accent);
            transform: translateX(5px);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 1.5rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--accent);
            color: var(--secondary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 3rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #bbb;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .menu-hero h1 {
                font-size: 2.5rem;
            }

            .menu-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 576px) {
            .menu-hero {
                height: 250px;
                margin-top: 70px;
            }

            .menu-hero h1 {
                font-size: 2rem;
            }

            .modal-img {
                height: 200px;
            }
        }
    </style>
    @stack('styles') {{-- Untuk CSS tambahan spesifik halaman --}}
</head>
<body>
    <header id="header">
        <div class="container header-container">
            <div class="logo">
                <i class="fas fa-utensils"></i>
                <span>Gourmet Palace</span>
            </div>
            <nav>
                <ul>
                    <li><a href="{{ route('menu.index') }}">Beranda</a></li> {{-- Gunakan route helper Laravel --}}
                    <li><a href="{{ route('menu.index') }}">Menu</a></li> {{-- Gunakan route helper Laravel --}}
                    @auth
                        <li><a href="{{ route('profile.edit') }}">Profile</a></li> {{-- Untuk user yang sudah login --}}
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li> {{-- Untuk user yang belum login --}}
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endauth
                    <li class="cart-icon">
                        {{-- <a href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart"></i></a> Akan kita buat nanti --}}
                        <a href="#"><i class="fas fa-shopping-cart"></i></a>
                        <span class="cart-count">0</span>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    {{-- Content section --}}
    @yield('content')

    <div class="modal" id="itemModal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div class="modal-img">
                <img id="modalImage" src="" alt="">
            </div>
            <div class="modal-body">
                <span class="modal-category" id="modalCategory"></span>
                <h2 class="modal-title" id="modalTitle"></h2>
                <p class="modal-desc" id="modalDesc"></p>
                <div class="modal-price" id="modalPrice"></div>
                <button class="modal-add" id="modalAddBtn">Tambahkan ke Keranjang</button>
            </div>
        </div>
    </div>

    <div class="cart-notification" id="cartNotification">
        <i class="fas fa-check-circle"></i>
        <span>Item ditambahkan ke keranjang!</span>
    </div>

    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <h3>Tentang Kami</h3>
                    <p>Gourmet Palace adalah restoran bintang lima yang menawarkan pengalaman kuliner kelas dunia dengan bahan-bahan premium dan teknik memasak tingkat internasional.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Jam Operasional</h3>
                    <p>Senin - Jumat: 17:00 - 23:00<br>
                    Sabtu - Minggu: 12:00 - 23:00</p>
                </div>
                <div class="footer-col">
                    <h3>Kontak</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Sudirman No. 88, Jakarta</p>
                    <p><i class="fas fa-phone-alt"></i> (021) 555-1234</p>
                    <p><i class="fas fa-envelope"></i> info@gourmetpalace.id</p>
                </div>
                <div class="footer-col">
                    <h3>Tautan Cepat</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li><a href="{{ route('menu.index') }}">Menu</a></li>
                        <li><a href="#location">Location</a></li>
                        @auth
                            <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Gourmet Palace. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    {{-- Push scripts here if needed for specific pages --}}
    @stack('scripts')
    {{-- Global JS for modal and cart notification (moved here for consistency) --}}
    <script>
        // Cart Data (global across user pages using this layout)
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let cartCount = cart.reduce((total, item) => total + item.quantity, 0);
        document.querySelector('.cart-count').textContent = cartCount;

        // Modal Functions (global)
        const modal = document.getElementById('itemModal');
        const modalClose = document.querySelector('.modal-close');

        modalClose.addEventListener('click', () => {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });

        // Cart Notification Functions (global)
        function showNotification() {
            const notification = document.getElementById('cartNotification');
            notification.classList.add('show');

            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>