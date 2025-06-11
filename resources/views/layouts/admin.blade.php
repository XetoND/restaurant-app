<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Admin Dashboard - Gourmet Palace')</title>
  {{-- Ini adalah bagian <style> yang berisi CSS kustom Anda --}}
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f8f5f2;
      margin: 0;
      padding: 0;
      color: #333;
    }
    header {
      background: #1a1a1a;
      color: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header a {
      color: white;
      text-decoration: none;
      margin-left: 1rem;
    }
    .container {
      max-width: 1200px;
      margin: 2rem auto;
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    h2 {
      margin-bottom: 1rem;
    }
    .form-group {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 1rem;
    }
    .form-group input, .form-group select, .form-group textarea { /* Tambah textarea */
      padding: 0.5rem;
      font-size: 1rem;
      flex: 1;
    }
    .btn {
      padding: 10px 20px;
      background: #8b5a2b;
      color: white;
      border: none;
      cursor: pointer;
      margin-top: 1rem;
    }
    .btn:hover {
      background: #a06c3c;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 2rem;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 0.75rem;
      text-align: left;
    }
    th {
      background: #8b5a2b;
      color: white;
    }
    .profile {
      display: flex;
      align-items: center;
      gap: 1rem;
      text-decoration: none;
      color: inherit;
    }
    .profile:hover {
      text-decoration: underline; cursor: pointer;
    }
    .profile img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }
    .actions button, .actions a.btn { /* Tambah a.btn untuk konsistensi style */
      margin-right: 0.5rem;
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none; /* Untuk link */
      display: inline-block; /* Untuk link */
      text-align: center; /* Untuk link */
    }
    .edit {
      background: #3498db;
      color: white;
    }
    .delete {
      background: #e74c3c;
      color: white;
    }
    /* Tambahan untuk pesan flash */
    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 5px;
        color: white;
    }
    .alert-success {
        background-color: #28a745;
    }
    .alert-danger {
        background-color: #dc3545;
    }
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
    .form-check {
        margin-top: 0.5rem;
    }
    .form-check-input {
        margin-right: 0.5rem;
    }
  </style>
  @stack('styles') {{-- Blade Directive: Untuk menyisipkan CSS tambahan --}}
</head>
<body>
  <header>
    <h1>Manajemen Menu</h1> {{-- Judul utama di header --}}
    <nav>
      <a href="#">Dashboard</a> {{-- Menggunakan helper route() Laravel --}}
      <a href="{{ route('profile.edit') }}">Profil</a> {{-- Menggunakan helper route() Laravel --}}
    </nav>

    <div class="profile">
      <div>
        {{-- Menampilkan nama dan peran pengguna yang sedang login --}}
        <strong>{{ Auth::user()->name ?? 'Admin' }}</strong><br>
        <small>{{ Auth::user()->role ?? 'Super Admin' }}</small>
      </div>
      <img src="{{ asset('path/to/your/admin/profile/image.png') }}" alt="Admin"> {{-- Tempat untuk gambar profil admin --}}
       <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn" style="background: none; border: none; color: white; cursor: pointer; padding: 0;">Logout</button>
        </form>
    </div>
  </header>
  
  {{-- Ini adalah lokasi baru untuk notifikasi --}}
  @if(session('success'))
      <div class="alert alert-success" style="width: fit-content; margin: 1rem auto; text-align: center;">
          {{ session('success') }}
      </div>
  @endif
  @if(session('error'))
      <div class="alert alert-danger" style="width: fit-content; margin: 1rem auto; text-align: center;">
          {{ session('error') }}
      </div>
  @endif

  <div class="container">
    {{-- Ini adalah tempat utama di mana konten spesifik dari halaman anak akan dimasukkan --}}
    @yield('content')
  </div>

  @stack('scripts') {{-- Blade Directive: Untuk menyisipkan JavaScript tambahan --}}
</body>
</html> 