{{-- Menggunakan layout utama agar header dan footer konsisten --}}
@extends('layouts.user') 

@section('title', 'Login - Gourmet Palace')

@push('styles')
<style>
    /* Style khusus untuk halaman login */
    .login-section {
        padding: 10rem 0 6rem;
        min-height: 100vh;
        display: flex;
        align-items: center;
        background-color: var(--light);
    }
    
    .login-container {
        max-width: 500px;
        margin: 0 auto;
        width: 100%;
        background: white;
        padding: 3rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        text-align: center;
        border-radius: 8px;
    }
    
    .login-title h2 {
        font-size: 2.2rem;
        color: var(--secondary);
        margin-bottom: 1rem;
        position: relative;
        padding-bottom: 15px;
    }
    
    .login-title h2:after {
        content: '';
        position: absolute;
        width: 60px;
        height: 3px;
        background: var(--accent);
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .login-title p {
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
        border-radius: 4px;
        transition: all 0.3s ease;
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
        border: 1px solid var(--accent);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        background: transparent;
        color: var(--accent);
    }
    
    .login-options {
        margin-top: 2rem;
        font-size: 0.9rem;
        color: var(--text-light);
    }
    
    .login-options a {
        color: var(--accent);
        text-decoration: none;
    }

    .login-options a:hover {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
<section class="login-section">
    <div class="container">
        <div class="login-container">
            <div class="login-title">
                <h2>Selamat Datang</h2>
                <p>Silakan masuk dengan akun anda untuk melanjutkan pesanan Anda.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="alamat@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn-submit">
                        {{ __('Masuk') }}
                    </button>
                </div>
            </form>

            <div class="login-options">
                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</section>
@endsection