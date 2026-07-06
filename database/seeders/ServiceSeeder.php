<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * Port persis dari INSERT INTO services di database/seed.sql lama.
 */
class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['hair', 'PERAWATAN RAMBUT', 'Haircut & Blow', 'Potong rambut dengan styling profesional', 60, 120000, null],
            ['hair', 'PERAWATAN RAMBUT', 'Hair Coloring', 'Pewarnaan rambut dengan hasil maksimal', 120, null, '350000'],
            ['hair', 'PERAWATAN RAMBUT', 'Hair Smoothing', 'Pelurus rambut dengan teknologi modern', 150, null, '400000'],
            ['hair', 'PERAWATAN RAMBUT', 'Hair Spa & Mask', 'Perawatan rambut intensif dengan masker premium', 90, 180000, null],
            ['face', 'PERAWATAN WAJAH', 'Facial Basic', 'Facial dasar untuk pembersihan kulit', 60, 180000, null],
            ['face', 'PERAWATAN WAJAH', 'Facial Premium', 'Facial eksklusif dengan treatment mendalam', 90, 280000, null],
            ['face', 'PERAWATAN WAJAH', 'Facial Brightening', 'Facial pencerah untuk kulit lebih bercahaya', 75, 250000, null],
            ['face', 'PERAWATAN WAJAH', 'Anti-Aging Treatment', 'Treatment anti-penuaan untuk kulit lebih muda', 90, 350000, null],
            ['nail', 'PERAWATAN KUKU', 'Manicure Standard', 'Perawatan kuku tangan standar', 45, 85000, null],
            ['nail', 'PERAWATAN KUKU', 'Pedicure Standard', 'Perawatan kuku kaki standar', 45, 95000, null],
            ['nail', 'PERAWATAN KUKU', 'Manicure & Pedicure Combo', 'Paket perawatan tangan dan kaki lengkap', 90, 150000, null],
            ['nail', 'PERAWATAN KUKU', 'Gel Manicure/Pedicure', 'Nail gel yang tahan lama dan berkualitas', 60, 120000, null],
            ['nail', 'PERAWATAN KUKU', 'Nail Art Custom', 'Desain kuku custom sesuai keinginan Anda', 90, null, '200000'],
        ];

        foreach ($services as [$category, $categoryName, $name, $description, $duration, $price, $priceRange]) {
            Service::updateOrCreate(
                ['name' => $name],
                [
                    'category' => $category,
                    'category_name' => $categoryName,
                    'description' => $description,
                    'duration' => $duration,
                    'price' => $price,
                    'price_range' => $priceRange,
                ]
            );
        }
    }
}
