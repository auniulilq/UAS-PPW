<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Nama tabel ini adalah 'carts', yang sudah sesuai dengan konvensi Laravel,
    // jadi 'protected $table = 'carts';' bisa dihilangkan atau tetap ditulis.
    // protected $table = 'carts';

    /**
     * Nama kolom yang menyimpan timestamp 'created_at' pada tabel.
     * Secara default Laravel mencari 'created_at'. Jika Anda menggunakan 'added_at' sebagai pengganti,
     * Anda perlu menentukannya di sini. Namun, jika Anda memiliki 'created_at' dan 'added_at'
     * dan 'added_at' memiliki fungsi khusus (misal: waktu barang ditambahkan ke keranjang),
     * maka biarkan 'created_at' standar dan tambahkan 'added_at' ke fillable.
     * Berdasarkan screenshot, Anda punya 'created_at' dan 'added_at'.
     */
    // protected $created_at = 'added_at'; // Hanya jika Anda ingin 'added_at' berfungsi sebagai 'created_at' otomatis Laravel.
                                        // Tapi karena ada 'created_at' juga, sebaiknya biarkan default dan isi 'added_at' manual atau di fillable.

    /**
     * Atribut yang dapat diisi secara massal.
     * Sesuaikan dengan nama kolom yang ada di tabel 'carts'.
     */
    protected $fillable = [
        'product_id',
        'quantity',
        'added_at', // Karena ini bukan timestamp bawaan Laravel, perlu dimasukkan ke fillable jika diisi manual
    ];

    /**
     * Atribut yang harus di-cast ke tipe data asli.
     */
    protected $casts = [
        'quantity' => 'integer',
        'added_at' => 'datetime', // Pastikan kolom ini benar-benar menyimpan timestamp yang valid
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // --- Relasi (Sangat Direkomendasikan) ---
    // Setiap item keranjang (Cart) adalah milik satu produk.
    public function product()
    {
        // Cart memiliki relasi 'belongsTo' ke Product, melalui 'product_id'
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}