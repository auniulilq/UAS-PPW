@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4 text-primary">🧾 Riwayat Pemesanan</h2>

    @if ($orders->isEmpty())
        <div class="alert alert-info text-center">Belum ada pesanan yang Anda buat.</div>
    @else
        @foreach ($orders as $order)
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>ID:</strong> #{{ $order->id }}<br>
                            <strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}
                        </div>
                        <div>
                            <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    <p><strong>Metode Pembayaran:</strong> {{ optional($order->payment)->method ?? '-' }}</p>

                    <ul class="list-group mb-3">
                        @foreach ($order->orderItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $item->product->name ?? 'Produk tidak ditemukan' }}</strong><br>
                                    <small>Jumlah: {{ $item->quantity }}</small>
                                </div>
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Tombol (opsional) --}}
                    <a href="#" class="btn btn-sm btn-outline-secondary">Lihat Invoice</a>
                </div>
