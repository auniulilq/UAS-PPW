@extends('layouts.app') {{-- Pastikan ini mengarah ke layout utama Anda --}}

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 80px;">
    <h1>Keranjang Belanja Anda</h1>

    {{-- Flash Messages (pastikan sudah ada di layout utama) --}}
    {{-- <div style="margin-top: 20px;">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div> --}}

    @if (empty($cart))
        <div class="empty-cart-message">
            <p>Keranjang Anda kosong. Yuk, <a href="{{ route('products.index') }}">mulai belanja</a>!</p>
        </div>
    @else
        <div class="cart-items-container">
            @foreach ($cart as $productId => $item)
                <div class="cart-item">
                    <div class="item-image">
                        <img src="{{ asset('storage/' . $item['image_url']) }}" alt="{{ $item['name'] }}">
                    </div>
                    <div class="item-details">
                        <h2 class="item-name">{{ $item['name'] }}</h2>
                        <p class="item-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        <div class="item-quantity-control">
                            {{-- Form untuk update kuantitas (opsional, bisa diimplementasikan nanti) --}}
                            <form action="{{ route('cart.update', $productId) }}" method="POST" class="quantity-form">
                                @csrf
                                @method('PUT') {{-- Gunakan method PUT untuk update --}}
                                <label for="quantity-{{ $productId }}">Jumlah:</label>
                                <input type="number" name="quantity" id="quantity-{{ $productId }}" value="{{ $item['quantity'] }}" min="1" class="quantity-input" onchange="this.form.submit()">
                                <input type="hidden" name="product_id" value="{{ $productId }}">
                            </form>
                            {{-- Tombol hapus --}}
                            <form action="{{ route('cart.remove', $productId) }}" method="POST" class="remove-form">
                                @csrf
                                @method('DELETE') {{-- Gunakan method DELETE untuk hapus --}}
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <div class="summary-total">
                <span>Total Belanja:</span>
                <span class="total-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="btn btn-primary checkout-button">Lanjutkan ke Pembayaran</a>
        </div>
    @endif
</div>
@endsection
