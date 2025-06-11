@extends('layouts.user')
@section('title', 'Pesanan Berhasil')
@section('content')
<div class="container" style="padding-top: 120px; text-align: center;">
    <i class="fas fa-check-circle" style="font-size: 5rem; color: var(--success); margin-bottom: 1rem;"></i>
    <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 1rem;">Pesanan Anda Berhasil Dibuat!</h1>
    <p style="font-size: 1.2rem; color: var(--text-light);">Terima kasih telah memesan. Kami akan segera memproses pesanan Anda.</p>
    <a href="{{ route('menu.index') }}" style="display: inline-block; margin-top: 2rem; padding: 1rem 2rem; background: var(--primary); color: white; text-decoration: none; border-radius: 5px;">Kembali ke Menu</a>
</div>
@endsection