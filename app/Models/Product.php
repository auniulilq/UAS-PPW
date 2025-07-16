<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id', // Pastikan ini ada dan benar
        'image_url',
    ];

    /**
     * Get the category that owns the product.
     * Ini adalah definisi relasi 'category'.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
