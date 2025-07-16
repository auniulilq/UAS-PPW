<?php

namespace App\Http\Controllers;

use App\Models\Cart;    // Asumsi: Model Cart merepresentasikan item keranjang
use App\Models\Product; // Import Product model untuk update stok
use App\Models\Payment; // Import Payment model untuk menyimpan transaksi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Untuk transaksi database
use Illuminate\Support\Facades\Session; // Import Session Facade

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman checkout dengan ringkasan keranjang.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    /**
     * Memproses pembayaran dan menyimpan transaksi.
     * Ini adalah simulasi pembayaran. Untuk real-world, akan ada integrasi Payment Gateway.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Request $request)
    {
        // 1. Validasi input form pembayaran
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:bank_transfer,credit_card,e_wallet', // Sesuaikan
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // 2. Mulai Transaksi Database (penting untuk konsistensi data)
        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $cartItemsForDB = []; // Untuk menyimpan ke tabel 'carts' atau 'order_items' jika ada

            foreach ($cart as $productId => $item) {
                $totalAmount += $item['price'] * $item['quantity'];

                // Verifikasi stok produk sebelum menyimpan pesanan
                $product = Product::find($productId);
                if (!$product || $product->stock < $item['quantity']) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Stok produk "' . $item['name'] . '" tidak mencukupi atau produk tidak ditemukan.');
                }
                
                // Kurangi stok produk
                $product->stock -= $item['quantity'];
                $product->save();

                // Siapkan data untuk disimpan ke tabel 'carts' (yang bertindak sebagai order_items di sini)
                $cartItemsForDB[] = [
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'added_at' => now(), // Atau ambil dari input jika ada
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // 3. Simpan data pembayaran ke tabel 'payments'
            // Perhatikan: Tabel 'payments' Anda memiliki 'payment_id' sebagai PK, dan 'cart_id' sebagai FK
            // Jika 'cart_id' di tabel payments merujuk ke primary key 'id' di tabel carts
            // maka kita harus mendapatkan ID dari record yang disimpan di tabel 'carts'
            // Di sini, kita akan membuat record di tabel `carts` untuk merepresentasikan satu transaksi.
            // Ini asumsi interpretasi struktur database Anda.
            // Jika tabel `carts` Anda dimaksudkan sebagai tabel `order_items`, maka ini akan menjadi `Order` dan `OrderItem`.
            // Untuk kesederhanaan, kita akan anggap satu entri di `carts` mewakili satu set pembelian yang berasosiasi dengan satu `payment`.
            // Ini bisa jadi sedikit tricky karena `carts` Anda per item.
            // Untuk skenario ini, kita akan membuat entri di tabel `carts` untuk setiap item yang dibeli,
            // dan kemudian mereferensikan `id` dari salah satu `cart` (item) ini ke tabel `payments`.
            // ATAU, lebih baik: buat tabel 'orders' dulu.

            // Karena struktur Anda: carts (id, product_id, quantity), payments (payment_id, cart_id)
            // Ini menyiratkan bahwa setiap pembayaran terkait dengan *satu entri di tabel carts*.
            // Ini agak tidak biasa untuk e-commerce (biasanya payment terkait order, dan order punya banyak order_items)
            // Mari kita asumsikan `cart_id` di `payments` akan merujuk ke *id* dari salah satu item di keranjang yang baru saja disimpan.
            // ATAU, lebih masuk akal, kita bisa menganggap `cart_id` di `payments` merujuk ke ID dari 'keranjang utama'
            // yang menyimpan banyak `cart_items`. Jika tidak ada tabel 'keranjang utama', kita perlu improvisasi.

            // ALTERNATIF Skenario (Lebih Umum):
            // Jika Anda ingin Payment terhubung ke kumpulan item, Anda perlu tabel `orders` yang menyimpan `cart_id`.
            // Order -> order_items (yang mirip dengan carts Anda)
            // Payment -> order_id
            // Namun, karena Anda tidak punya tabel `orders` di screenshot, kita akan coba sesuaikan.

            // Opsi 1 (Sederhana, tapi mungkin tidak ideal untuk relasi):
            // Simpan semua item keranjang ke tabel 'carts' Anda.
            // Kemudian buat entri payment. Ambil ID dari salah satu item cart yang disimpan
            // untuk menjadi foreign key di tabel 'payments'. Ini agak janggal.

            // Opsi 2 (Lebih Baik, tapi butuh sedikit modifikasi konsep):
            // Anggap tabel `carts` sebagai `order_items` yang menyimpan detail produk yang dibeli.
            // Buat sebuah `cart_id` dummy yang akan mengelompokkan semua item ini untuk satu pembayaran.
            // Ini akan memerlukan penyesuaian di tabel `carts` jika `id`nya auto-incrementing.
            // Atau, kita bisa membuat satu record di tabel `carts` yang menyimpan `user_id` dan `status` (seperti 'checkout'),
            // dan tabel `cart_items` yang menyimpan `cart_id`, `product_id`, `quantity`.
            // Tapi karena Anda sudah punya `carts` dengan `product_id`, kita akan coba improvisasi.

            // **Mari kita improvisasi berdasarkan struktur Anda:**
            // Kita akan menyimpan semua item yang dibeli ke tabel `carts`.
            // Kemudian kita akan membuat satu `payment` yang merujuk ke salah satu `id` dari `cart` yang baru saja dibuat.
            // Ini tidak ideal untuk pelacakan order keseluruhan, tapi sesuai dengan struktur tabel Anda.
            // Atau, yang lebih baik, tabel `payments` punya kolom lain untuk `transaction_group_id` atau `order_ref_id`.
            // Jika Anda tidak punya tabel `orders`, mari kita buat `payment_id` yang unik untuk grup transaksi ini,
            // dan tabel `carts` bisa kita anggap sebagai `order_items`.

            $uniquePaymentRef = 'TXN-' . now()->format('YmdHis') . '-' . uniqid(); // Contoh ID transaksi unik

            // Simpan setiap item keranjang ke tabel `carts` Anda
            // (yang di sini berfungsi seperti `order_items` untuk transaksi ini)
            $cartIdsForThisPayment = [];
            foreach ($cartItemsForDB as $itemData) {
                // Tambahkan 'payment_ref_id' ke tabel 'carts' jika Anda ingin mengelompokkan item per pembayaran
                // Tapi ini akan mengubah struktur tabel 'carts'.
                // Jika tidak, kita hanya menyimpan item.
                $savedCartItem = Cart::create($itemData); // Simpan item ke tabel 'carts'
                $cartIdsForThisPayment[] = $savedCartItem->id;
            }

            // Pilih salah satu cart_id dari item yang baru disimpan untuk direferensikan di tabel payments.
            // Ini adalah pendekatan yang perlu disesuaikan jika logika Order/Payment Anda lebih kompleks.
            $representativeCartId = !empty($cartIdsForThisPayment) ? $cartIdsForThisPayment[0] : null;

            $paymentId = 'PAY-' . now()->format('YmdHis') . '-' . uniqid(); // Pastikan payment_id unik dan sesuai varchar

            Payment::create([
                'payment_id' => $paymentId, // Harus unik
                'cart_id' => $representativeCartId, // Referensi ke salah satu item keranjang (ini bisa jadi kurang ideal)
                'amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'status' => 'completed', // Langsung completed untuk simulasi
                'paid_at' => now(),
            ]);

            DB::commit(); // Konfirmasi semua perubahan ke database

            // Bersihkan keranjang belanja dari session
            Session::forget('cart');

            // 4. Siapkan data invoice untuk pop-up
            $invoiceData = [
                'invoice_number' => $paymentId, // Menggunakan payment_id sebagai invoice_number
                'total_amount' => $totalAmount,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_address' => $request->customer_address,
                'payment_method' => $request->payment_method,
                'items' => $cart, // Mengirim detail item dari keranjang untuk ditampilkan di invoice
                // 'payment_id_from_db' => $payment->payment_id, // Jika Anda ingin ID dari DB
            ];

            // Redirect dengan data invoice di session untuk pop-up
            return redirect()->route('home')->with('success_payment', $invoiceData);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika terjadi error
            \Log::error('Payment processing failed: ' . $e->getMessage()); // Log error untuk debugging
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi. Detail: ' . $e->getMessage());
        }
    }
}