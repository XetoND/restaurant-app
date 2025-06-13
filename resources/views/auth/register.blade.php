{{-- Menggunakan layout utama untuk user agar header dan footer konsisten --}}
@extends('layouts.user')

@section('title', 'Daftar Akun - Gourmet Palace')

@push('styles')
<style>
    /* Style khusus untuk halaman registrasi */
    .register-section {
        padding: 10rem 0 6rem;
        min-height: 100vh;
        display: flex;
        align-items: center;
        background-color: var(--light);
    }
    
    .register-container {
        max-width: 600px;
        margin: 0 auto;
        width: 100%;
        background: white;
        padding: 3rem;
        box-shadow: 0 10px
 30px rgba(0, 0, 0, 0.05);
        text-align: center;
        border-radius: 8px;
    }
    
    .register-title h2 {
        font-size: 2.2rem;
        color: var(--secondary);
        margin-bottom: 1rem;
        position: relative;
        padding-bottom: 15px;
    }
    
    .register-title h2:after {
        content: '';
        position: absolute;
        width: 60px;
        height: 3px;
        background: var(--accent);
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .register-title p {
        color: var(--text-light);
        font-size: 1rem;
        margin-top: 1rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        text-align: left;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--secondary);
        font-weight: 500;
    }
    
    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        background: #f9f9f9;
        font-size: 1rem;
        transition: all 0.3s ease;
        border-radius: 4px; /* Menambahkan border-radius */
    }
    
    .form-group input:focus {
        border-color: var(--accent);
        background: white;
        outline: none;
    }
    
    .btn-submit {
        display: inline-block;
        padding: 15px 40px;
        background: var(--accent);
        color: var(--secondary);
        border: none;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 1px;
        text-transform: uppercase;
        border: 1px solid var(--accent);
        width: 100%;
    }
    
    .btn-submit:hover {
        background: transparent;
        color: var(--accent);
    }
    
    .register-options {
        margin-top: 2rem;
        font-size: 0.9rem;
        color: var(--text-light);
    }
    
    .register-options a {
        color: var(--accent);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .register-options a:hover {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
<section class="register-section">
    <div class="container">
        <div class="register-container">
            <div class="register-title">
                <h2>Buat Akun Baru</h2>
                <p>Daftarkan diri Anda untuk akses ke pemesanan dan penawaran eksklusif.</p>
            </div>

            {{-- Menghubungkan form dengan backend Laravel --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="alamat@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                
                <button type="submit" class="btn-submit">
                    {{ __('Daftar Sekarang') }}
                </button>
            </form>

            <div class="register-options">
                <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</section>
@endsection