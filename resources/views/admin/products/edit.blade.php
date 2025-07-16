@extends('admin.layouts')

@section('content')
<div class="container">
    <div class="admin-form-container">
        <h2>Edit Produk: {{ $product->name }}</h2>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Penting untuk operasi UPDATE --}}

            <div class="form-group">
                <label for="name">Nama Produk:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea id="description" name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Harga (Rp):</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" step="1000" required>
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="stock">Stok:</label>
                <input type="number" id="stock" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
                @error('stock')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="category_id">Kategori:</label> {{-- Label diubah menjadi category_id --}}
                <select id="category_id" name="category_id" class="form-control"> {{-- Input diubah menjadi select --}}
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') {{-- Error message juga untuk category_id --}}
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">Gambar Produk (Biarkan kosong jika tidak ingin mengubah):</label>
                <input type="file" id="image" name="image" class="form-control">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @if ($product->image_url)
                    <div class="image-preview">
                        <p>Gambar Saat Ini:</p>
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}">
                    </div>
                @endif
            </div>

            <div class="admin-form-buttons">
                <button type="submit" class="btn btn-primary">Perbarui Produk</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-product-form').submit();">Hapus Produk Ini</button>
            </div>
        </form>

        {{-- Form terpisah untuk DELETE --}}
        <form id="delete-product-form" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
