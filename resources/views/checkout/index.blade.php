@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6 text-center">Checkout Pembayaran</h1>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4">Ringkasan Pesanan</h2>
        <table class="min-w-full divide-y divide-gray-200 mb-4">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($cart as $id => $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item['quantity'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-between items-center text-xl font-bold border-t pt-4">
            <span>Total Belanja:</span>
            <span class="text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold mb-4">Detail Pelanggan & Pembayaran</h2>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="customer_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap:</label>
                <input type="text" id="customer_name" name="customer_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('customer_name') border-red-500 @enderror" value="{{ old('customer_name') }}" required>
                @error('customer_name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="customer_email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" id="customer_email" name="customer_email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('customer_email') border-red-500 @enderror" value="{{ old('customer_email') }}" required>
                @error('customer_email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="customer_address" class="block text-gray-700 text-sm font-bold mb-2">Alamat Pengiriman:</label>
                <textarea id="customer_address" name="customer_address" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('customer_address') border-red-500 @enderror" required>{{ old('customer_address') }}</textarea>
                @error('customer_address')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="payment_method" class="block text-gray-700 text-sm font-bold mb-2">Metode Pembayaran:</label>
                <select id="payment_method" name="payment_method" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('payment_method') border-red-500 @enderror" required>
                    <option value="">Pilih Metode Pembayaran</option>
                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
                    <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                </select>
                @error('payment_method')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-lg">
                    Bayar Sekarang
                </button>
                <a href="{{ route('cart.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                    Kembali ke Keranjang
                </a>
            </div>
        </form>
    </div>
</div>
@endsection