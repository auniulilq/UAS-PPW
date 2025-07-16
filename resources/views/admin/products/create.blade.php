@extends('admin.layouts')

@section('content')
<div class="container">
    <div class="admin-form-container">
        <h2>Tambah Produk Baru</h2>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nama Produk:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea id="description" name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Harga (Rp):</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" min="0" step="1000" required>
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="stock">Stok:</label>
                <input type="number" id="stock" name="stock" class="form-control" value="{{ old('stock') }}" min="0" required>
                @error('stock')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="category_id">Kategori:</label> {{-- Label diubah menjadi category_id --}}
                <select id="category_id" name="category_id" class="form-control"> {{-- Input diubah menjadi select --}}
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') {{-- Error message juga untuk category_id --}}
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">Gambar Produk:</label>
                <input type="file" id="image" name="image" class="form-control">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="admin-form-buttons">
                <button type="submit" class="btn btn-primary">Simpan Produk</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
