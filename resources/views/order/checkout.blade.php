@extends('layouts.app') {{-- Memperluas layout utama Anda --}}

@section('content')
<div class="container checkout-page">
    <h1>Lanjutkan Pembayaran</h1>

    {{-- Flash Messages (pastikan sudah aktif di layouts/app.blade.php) --}}
    {{-- Bagian ini dikomentari karena diasumsikan sudah ada di layout utama --}}
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
            <p>Keranjang Anda kosong. Tidak ada yang bisa di-checkout. Yuk, <a href="{{ route('products.index') }}">mulai belanja</a>!</p>
        </div>
    @else
        <div class="checkout-content">
            <div class="shipping-details">
                <h2>Detail Pengiriman</h2>
                {{-- PASTIKAN TAG <form> INI MENGELILINGI SEMUA INPUT DAN TOMBOL SUBMIT --}}
                <form action="{{ route('order.place') }}" method="POST"> class="checkout-form">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Lengkap:</label>
                        <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Nomor Telepon:</label>
                        <input type="text" id="phone" name="phone" class="form-control" required value="{{ old('phone') }}">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat Pengiriman:</label>
                        <textarea id="address" name="address" class="form-control" rows="4" required>{{ old('address') }}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="city">Kota:</label>
                        <input type="text" id="city" name="city" class="form-control" required value="{{ old('city') }}">
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Kode Pos:</label>
                        <input type="text" id="postal_code" name="postal_code" class="form-control" required value="{{ old('postal_code') }}">
                        @error('postal_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <h2 style="margin-top: 40px;">Metode Pembayaran</h2>
                    <div class="payment-methods">
                        <div class="payment-option">
                            <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" required checked>
                            <label for="bank_transfer">Transfer Bank</label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="credit_card" name="payment_method" value="credit_card" required>
                            <label for="credit_card">Kartu Kredit/Debit</label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="e_wallet" name="payment_method" value="e_wallet" required>
                            <label for="e_wallet">E-Wallet</label>
                        </div>
                        @error('payment_method')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="order-summary-details">
                        <h3>Ringkasan Pesanan</h3>
                        <div class="summary-items">
                            @foreach ($cart as $productId => $item)
                                <div class="summary-item">
                                    <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                                    <span>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="summary-total final">
                            <span>Total Pembayaran:</span>
                            <span class="total-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success place-order-button">Bayar Sekarang</button>
                    <a href="{{ route('cart.index') }}" class="btn btn-primary back-to-cart-button">Kembali ke Keranjang</a>
                </form> {{-- PASTIKAN TAG </form> INI ADA DI SINI --}}
            </div>
        </div>
    @endif
</div>
@endsection
