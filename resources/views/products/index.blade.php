@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2 class="text-center mb-4 text-primary">Produk Kami</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($products as $product)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <small class="text-muted">Kategori: {{ $product->category->name }}</small>
                        <p class="fw-bold text-warning mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="mt-auto">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-detail mb-2">Detail</a>
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-cart">+ Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
