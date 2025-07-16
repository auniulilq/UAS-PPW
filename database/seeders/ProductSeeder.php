<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category; // Import model Category

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan tabel products kosong sebelum diisi (opsional jika selalu migrate:fresh)
        // DB::table('products')->truncate();

        // Pastikan ada kategori yang tersedia untuk dihubungkan
        $fashionCategory = Category::firstOrCreate(['name' => 'Fashion'], ['description' => 'Pakaian, aksesoris, dan gaya terbaru.']);
        $footwearCategory = Category::firstOrCreate(['name' => 'Footwear'], ['description' => 'Koleksi sepatu untuk setiap langkah Anda.']);
        $electronicsCategory = Category::firstOrCreate(['name' => 'Electronics'], ['description' => 'Gadget dan perangkat teknologi modern.']);
        $accessoriesCategory = Category::firstOrCreate(['name' => 'Accessories'], ['description' => 'Pelengkap gaya dan kebutuhan sehari-hari.']);


        DB::table('products')->insert([
            [
                'name' => 'Kaos Polos Hitam',
                'description' => 'Kaos katun nyaman dan adem untuk sehari-hari.',
                'price' => 75000,
                'stock' => 20,
                'category_id' => $fashionCategory->id, // Gunakan ID kategori
                'image_url' => 'products/kaos-polos-hitam.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sepatu Sneakers X',
                'description' => 'Sepatu ringan untuk aktivitas olahraga atau kasual.',
                'price' => 350000,
                'stock' => 10,
                'category_id' => $footwearCategory->id, // Gunakan ID kategori
                'image_url' => 'products/sepatu-sneakers-x.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jam Tangan Classic',
                'description' => 'Jam tangan analog kulit asli, desain elegan.',
                'price' => 150000,
                'stock' => 5,
                'category_id' => $accessoriesCategory->id, // Gunakan ID kategori
                'image_url' => 'products/jam-tangan-classic.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hoodie Oversize',
                'description' => 'Hoodie bahan fleece tebal, nyaman untuk cuaca dingin.',
                'price' => 120000,
                'stock' => 15,
                'category_id' => $fashionCategory->id, // Gunakan ID kategori
                'image_url' => 'products/hoodie-oversize.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Headphone Bass HD',
                'description' => 'Headphone over-ear dengan suara bass jernih dan kuat.',
                'price' => 250000,
                'stock' => 8,
                'category_id' => $electronicsCategory->id, // Gunakan ID kategori
                'image_url' => 'products/headphone-bass-hd.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
