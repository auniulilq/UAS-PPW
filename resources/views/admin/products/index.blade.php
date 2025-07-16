@extends('admin.layouts') {{-- Memperluas layout admin --}}

@section('content')
<div class="container">
    <h1 class="admin-panel-title">Manajemen Produk</h1>

    <a href="{{ route('admin.products.create') }}" class="btn admin-add-button">Tambah Produk Baru</a>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    @if ($product->image_url)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
                    @else
                        <img src="https://placehold.co/70x70/E0E0E0/808080?text=No+Image" alt="No Image" style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                {{-- Tampilkan nama kategori dari relasi --}}
                <td>{{ $product->category->name ?? '-' }}</td> {{-- Perubahan ada di baris ini --}}
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada produk yang ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination Links --}}
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
