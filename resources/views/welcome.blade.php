@extends('layouts.app') {{-- Memperluas layout utama Anda --}}

@section('content')
<div class="hero-section">
    <div class="container hero-content">
        <h1>Selamat Datang di MyShop</h1>
        <p>Temukan produk fashion dan aksesoris terbaru dengan harga terbaik.</p>
        <a href="{{ route('products.index') }}" class="hero-button">Mulai Belanja Sekarang</a>
    </div>
</div>

<div class="container features-section">
    <h2 class="section-title">Mengapa Memilih Kami?</h2>
    <div class="features-grid">
        <div class="feature-item">
            <div class="feature-icon">✨</div>
            <h3>Produk Berkualitas</h3>
            <p>Kami hanya menyediakan produk dengan kualitas terbaik untuk kepuasan Anda.</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">🚚</div>
            <h3>Pengiriman Cepat</h3>
            <p>Pesanan Anda akan sampai di tangan Anda dengan cepat dan aman.</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">💳</div>
            <h3>Pembayaran Aman</h3>
            <p>Berbagai metode pembayaran yang aman dan terpercaya tersedia.</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">📞</div>
            <h3>Dukungan Pelanggan</h3>
            <p>Tim kami siap membantu Anda kapan saja Anda butuhkan.</p>
        </div>
    </div>
</div>

<div class="container call-to-action-section">
    <h2 class="section-title">Jangan Lewatkan Penawaran Spesial!</h2>
    <p>Dapatkan diskon menarik dan penawaran eksklusif hanya untuk Anda.</p>
    <a href="{{ route('products.index') }}" class="hero-button secondary">Lihat Semua Produk</a>
</div>
@endsection
