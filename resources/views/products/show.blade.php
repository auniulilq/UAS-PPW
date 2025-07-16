<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nama Toko Anda</title>
    @vite('resources/css/app.css')
    {{-- Atau jika Anda masih menggunakan asset() --}}
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>
<body>
    <div class="navbar">
        <div class="container">
            <a class="navbar-brand" href="/">MyShop</a>
            <div class="navbar-links">
                <a href="/">Home</a>
                <a href="/products">Products</a>
                <a href="/cart">Keranjang</a>
            </div>
        </div>
    </div>

    <div class="container product-detail">
        <div class="product-image">
            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}">
        </div>
        <div class="product-info">
            <h1 class="product-title">{{ $product->name }}</h1>
            <p class="product-category">Kategori: {{ $product->category }}</p>
            <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="product-description">{{ $product->description }}</p>
            <p class="product-stock">Stok: {{ $product->stock }} tersedia</p>
            <div class="product-actions">
<form action="{{ route('cart.store') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <button type="submit" class="btn btn-success">Tambah ke Keranjang</button>
</form>
                <a href="{{ route('products.index') }}" class="back-to-products">Kembali ke Daftar Produk</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            © {{ date('Y') }} MyShop. All rights reserved.
        </div>
    </div>

    {{-- @vite('resources/js/app.js') --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>