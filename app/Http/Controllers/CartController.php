<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Payment; // Import model Payment
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB; // Import DB Facade untuk transaksi database

class CartController extends Controller
{
    /**
     * Menampilkan isi keranjang belanja.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil keranjang dari session. Jika belum ada, kembalikan array kosong.
        $cart = Session::get('cart', []);
        $total = 0;

        // Hitung total harga keranjang
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Menambahkan produk ke keranjang.
     * Method ini akan dipanggil oleh route 'cart.store'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) // Mengubah nama method dari 'add' menjadi 'store'
    {
        // Validasi input product_id dari form
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = $request->input('product_id');

        // Cari produk berdasarkan ID yang diterima dari request
        $product = Product::find($productId);

        // Jika produk tidak ditemukan (meskipun sudah divalidasi, ini untuk keamanan ekstra)
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $cart = Session::get('cart', []);

        // Periksa apakah produk sudah ada di keranjang
        if (isset($cart[$product->id])) {
            // Jika sudah ada, tambahkan kuantitas
            $cart[$product->id]['quantity']++;
        } else {
            // Jika belum ada, tambahkan produk baru ke keranjang
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                // Pastikan kolom 'image_url' ada di tabel products
                "image_url" => $product->image_url ?? 'no_image.jpg' // Fallback jika image_url kosong
            ];
        }

        Session::put('cart', $cart); // Simpan kembali keranjang ke session
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menghapus produk dari keranjang.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Product $product)
    {
        $cart = Session::get('cart');
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]); // Hapus item dari array keranjang
            Session::put('cart', $cart); // Simpan kembali keranjang yang sudah diupdate
        }
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    /**
     * Memperbarui kuantitas produk di keranjang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        $cart = Session::get('cart');
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Jumlah produk berhasil diperbarui!');
    }

    /**
     * Menampilkan halaman checkout.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function checkout()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong, tidak bisa melanjutkan ke pembayaran.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('order.checkout', compact('cart', 'total'));
    }

    /**
     * Memproses order dan menyimpannya ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function placeOrder(Request $request)
    {
        // 1. Validasi data input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255', // Pastikan validasi ini ada
            'postal_code' => 'required|string|max:10', // Pastikan validasi ini ada
            'payment_method' => 'required|string|in:bank_transfer,credit_card,e_wallet',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong, tidak bisa membuat pesanan.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 2. Simpan order ke database
        try {
            DB::beginTransaction(); // Mulai transaksi database

            // Simpan data order utama ke tabel 'orders'
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => auth()->id() ?? null, // Jika ada sistem user, gunakan auth()->id()
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                // Pastikan 'city' dan 'postal_code' disertakan di sini
                'shipping_address' => $request->address . ', ' . $request->city . ' ' . $request->postal_code,
                'total_amount' => $total,
                // 'payment_method' => $request->payment_method, // Tidak lagi disimpan langsung di sini jika ada tabel payments
                'status' => 'pending', // Status awal pesanan
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Simpan detail item order ke tabel 'order_items'
            foreach ($cart as $productId => $item) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Kurangi stok produk (opsional, tapi penting untuk e-commerce)
                $product = Product::find($productId);
                if ($product) {
                    $product->stock -= $item['quantity'];
                    $product->save();
                }
            }

            // Simpan detail pembayaran ke tabel 'payments'
            Payment::create([ // Menggunakan model Payment
                'order_id' => $orderId,
                'method' => $request->payment_method,
                'amount' => $total,
                'status' => 'pending', // Status pembayaran awal
                'transaction_id' => null, // Ini akan diisi jika ada integrasi gateway pembayaran
                'paid_at' => null,
            ]);


            Session::forget('cart'); // Hapus keranjang dari sesi setelah order berhasil
            DB::commit(); // Commit transaksi

            return redirect()->route('products.index')->with('success', 'Pesanan Anda berhasil ditempatkan! Silakan lanjutkan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika ada error
            // Log error atau tampilkan pesan yang lebih spesifik
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menempatkan pesanan. Silakan coba lagi. ' . $e->getMessage());
        }
    }
}
