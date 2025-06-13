@extends('layouts.admin')

@section('title', 'Edit Menu: ' . $menuItem->name)

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Menu: {{ $menuItem->name }}</h1>

    <div class="card shadow mb-4">
        <form action="{{ route('admin.menu-items.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.menu-items.form', ['menuItem' => $menuItem])
        </form>
    </div>
</div>
@endsection