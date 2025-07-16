<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController; // Pastikan ini diimpor
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes (Frontend)
Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class)->only(['index', 'show']);

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::put('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
Route::post('/order', [CartController::class, 'placeOrder'])->name('order.place');

// Rute untuk Halaman Kategori (Pastikan ini ada dan benar)
Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');


// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Rute untuk mengelola produk
    Route::resource('products', AdminProductController::class);

    // Rute untuk mengelola kategori
    Route::resource('categories', AdminCategoryController::class);
});

Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('order.place');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::post('/cart', [CartController::class, 'store'])->name('cart.store');

Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');

