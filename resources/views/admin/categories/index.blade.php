@extends('admin.layouts') {{-- Memperluas layout admin --}}

@section('content')
<div class="container">
    <h1 class="admin-panel-title">Manajemen Kategori</h1>

    <a href="{{ route('admin.categories.create') }}" class="btn admin-add-button">Tambah Kategori Baru</a>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description ?? '-' }}</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada kategori yang ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination Links --}}
    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
