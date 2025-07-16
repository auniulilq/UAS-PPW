@extends('admin.layouts')

@section('content')
<div class="container">
    <div class="admin-form-container">
        <h2>Edit Kategori: {{ $category->name }}</h2>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Penting untuk operasi UPDATE --}}

            <div class="form-group">
                <label for="name">Nama Kategori:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea id="description" name="description" class="form-control" rows="5">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="admin-form-buttons">
                <button type="submit" class="btn btn-primary">Perbarui Kategori</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-category-form').submit();">Hapus Kategori Ini</button>
            </div>
        </form>

        {{-- Form terpisah untuk DELETE --}}
        <form id="delete-category-form" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
