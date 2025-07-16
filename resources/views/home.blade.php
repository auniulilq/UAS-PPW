{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Selamat datang di halaman utama!</h1>
        <p>{{ session('success') }}</p>
    </div>
@endsection
