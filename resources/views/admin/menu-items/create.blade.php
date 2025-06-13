@extends('layouts.admin')

@section('title', 'Tambah Menu Baru')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Menu Baru</h1>

    <div class="card shadow mb-4">
        <form action="{{ route('admin.menu-items.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.menu-items.form')
        </form>
    </div>
</div>
@endsection