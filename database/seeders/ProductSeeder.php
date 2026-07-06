<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['Hair Care', 'Serum Rambut Keratin', 'Serum keratin premium untuk rambut lurus, halus, dan berkilau sepanjang hari.', 145000, 20],
            ['Hair Care', 'Hair Mask Argan Oil', 'Masker rambut dengan argan oil murni, cocok untuk rambut kering dan rusak akibat kimia.', 89000, 30],
            ['Hair Care', 'Dry Shampoo Spray', 'Sampo kering praktis untuk menyegarkan rambut tanpa air, tahan hingga 8 jam.', 65000, 25],
            ['Face Care', 'Toner Brightening Rose', 'Toner pelembab sekaligus pencerah dengan ekstrak mawar alami, cocok untuk semua jenis kulit.', 98000, 40],
            ['Face Care', 'Sheet Mask Collagen', 'Masker sheet kolagen intensif untuk kulit kenyal, lembab, dan tampak muda.', 35000, 60],
            ['Face Care', 'Sunscreen SPF 50+', 'Tabir surya ringan non-greasy dengan perlindungan SPF 50+, aman untuk pemakaian harian.', 120000, 35],
            ['Face Care', 'Moisturizer Niacinamide', 'Pelembab harian dengan niacinamide 10% untuk meratakan warna kulit dan mengecilkan pori.', 135000, 28],
            ['Nail Care', 'Nail Polish Set (12 warna)', 'Set cat kuku 12 warna pilihan, formula tahan lama dan mudah diaplikasikan.', 175000, 15],
            ['Nail Care', 'Cuticle Oil Peach', 'Minyak kutikula beraroma peach untuk melembutkan dan merawat area kuku setiap hari.', 55000, 22],
            ['Body Care', 'Body Scrub Coffee', 'Scrub badan berbahan dasar kopi arabika untuk mengangkat sel kulit mati dan melembutkan kulit.', 115000, 18],
            ['Body Care', 'Lotion Whitening', 'Lotion pencerah badan dengan kandungan vitamin C dan glutathione, tekstur ringan tidak lengket.', 95000, 24],
        ];

        foreach ($products as [$category, $name, $description, $price, $stock]) {
            Product::updateOrCreate(
                ['name' => $name],
                [
                    'category' => $category,
                    'description' => $description,
                    'price' => $price,
                    'stock' => $stock,
                    'is_active' => true,
                ]
            );
        }
    }
}
