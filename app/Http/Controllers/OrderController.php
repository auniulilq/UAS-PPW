<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Ambil keranjang
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Simpan pesanan
        $order = new Order();
        $order->user_id = Auth::check() ? Auth::id() : null;
        $order->customer_name = $request->name;
        $order->customer_email = $request->email;
        $order->customer_phone = $request->phone;
        $order->shipping_address = $request->address;
        $order->city = $request->city;
        $order->postal_code = $request->postal_code;
        $order->payment_method = $request->payment_method;
        $order->total_amount = $total;
        $order->status = 'pending';
        $order->save();

        // Format invoice HTML
        $invoiceHtml = "
            <div style='text-align:left'>
                <strong>Invoice ID:</strong> #{$order->id}<br>
                <strong>Nama:</strong> {$order->customer_name}<br>
                <strong>Email:</strong> {$order->customer_email}<br>
                <strong>No. Telepon:</strong> {$order->customer_phone}<br>
                <strong>Alamat:</strong> {$order->shipping_address}, {$order->city}, {$order->postal_code}<br>
                <strong>Total Bayar:</strong> Rp " . number_format($order->total_amount, 0, ',', '.') . "<br>
                <strong>Metode:</strong> {$order->payment_method}<br>
            </div>
        ";

        // Simpan ke session
        session()->flash('success', 'Pesanan berhasil dibuat!');
        session()->flash('invoice', $invoiceHtml);

        // Kosongkan keranjang
        session()->forget('cart');
        session()->forget('cart_total');

        return redirect()->route('products.index');
        
    }

    public function history()
{
    $orders = \App\Models\Order::where('user_id', auth()->id())
                ->latest()
                ->with('orderItems.product') // kalau pakai relasi order_items dan product
                ->get();

    return view('orders.history', compact('orders'));
}

}
