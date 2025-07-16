<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // Import model Category
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk atau produk berdasarkan kategori.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter berdasarkan kategori jika ada parameter 'category' di URL
        if ($request->has('category') && $request->input('category') !== null) {
            $categoryName = $request->input('category');
            // Cari ID kategori berdasarkan nama
            $category = Category::where('name', $categoryName)->first();

            if ($category) {
                $query->where('category_id', $category->id);
            } else {
                // Jika kategori tidak ditemukan, bisa tampilkan pesan error atau produk kosong
                $query->whereRaw('1 = 0'); // Tampilkan produk kosong jika kategori tidak valid
            }
            
        }

        // Eager load relasi 'category' untuk menghindari N+1 problem di tampilan produk
        $products = $query->with('category')->orderBy('created_at', 'desc')->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan detail produk tertentu.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
