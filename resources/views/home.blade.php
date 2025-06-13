<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Palace - Fine Dining Experience</title>
    {{-- Menggunakan asset helper untuk CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <style>
        :root { --primary: #8b5a2b; --secondary: #1a1a1a; --accent: #c19a6b; --light: #f8f5f2; --dark: #333333; --success: #4caf50; --text: #333333; --text-light: #777777; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Playfair Display', serif; }
        body { background-color: var(--light); color: var(--text); line-height: 1.6; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
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
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Playfair Display', serif;
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
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }
        
        .cart-icon {
            position: relative;
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
        }
        
        .hero {
            background: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            position: relative;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
            width: 100%;
        }
        
        .hero h1 {
            font-size: 4.5rem;
        }
        
        .hero p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 1rem auto 2rem;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: var(--accent);
            color: var(--secondary);
            border: 1px solid var(--accent);
            text-decoration: none;
        }
        .btn-outline {
            background-color: var(--primary); /* Warna latar belakang utama */
            color: var(--light); /* Warna teks menjadi terang */
            border: 2px solid var(--primary); /* Border tetap dengan warna utama */
            transition: background-color 0.3s ease, color 0.3s ease; /* Efek transisi */
        }

        .btn-outline:hover {
            background-color: var(--accent); /* Warna latar belakang saat hover */
            color: var(--secondary); /* Warna teks saat hover */
            border-color: var(--accent); /* Warna border saat hover */
        }
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

    {{-- Konten halaman dari dashboard_user.html --}}
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="container">
                <h1>Pengalaman Kuliner Bintang Lima</h1>
                <p>Nikmati keahlian chef kami yang telah diakui secara internasional dengan bahan-bahan premium pilihan dari seluruh dunia</p>
                <div>
                    <a href="{{ route('menu.index') }}" class="btn btn-outline">Jelajahi Menu</a>
                </div>
            </div>
        </div>
    </section>

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

</body>
</html>