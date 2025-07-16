@extends('layouts.app') {{-- Memperluas layout utama Anda --}}

@section('content')
<div class="container categories-page">
    <h1 class="page-title">Jelajahi Kategori Produk</h1>

    <div class="categories-grid">
        <a href="{{ route('products.index', ['category' => 'Fashion']) }}" class="category-card">
            <div class="category-icon">👗</div>
            <h3>Fashion</h3>
            <p>Pakaian, aksesoris, dan gaya terbaru.</p>
        </a>
        <a href="{{ route('products.index', ['category' => 'Footwear']) }}" class="category-card">
            <div class="category-icon">👟</div>
            <h3>Footwear</h3>
            <p>Koleksi sepatu untuk setiap langkah Anda.</p>
        </a>
        <a href="{{ route('products.index', ['category' => 'Electronics']) }}" class="category-card">
            <div class="category-icon">📱</div>
            <h3>Electronics</h3>
            <p>Gadget dan perangkat teknologi modern.</p>
        </a>
        <a href="{{ route('products.index', ['category' => 'Accessories']) }}" class="category-card">
            <div class="category-icon">💍</div>
            <h3>Accessories</h3>
            <p>Pelengkap gaya dan kebutuhan sehari-hari.</p>
        </a>
    </div>
</div>
@endsection
