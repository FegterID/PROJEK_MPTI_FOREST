<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Katalog produk publik. Port dari pages/products.php.
     * (Chip kategori & search/sort di versi asli cuma dekorasi statis
     * aria-hidden, jadi di sini disederhanakan jadi grid per kategori
     * saja — konsisten dengan katalog layanan di stage 1.)
     */
    public function index(): View
    {
        $productsByCategory = Product::active()
            ->orderBy('category')
            ->orderBy('id')
            ->get()
            ->groupBy('category');

        return view('products.index', [
            'productsByCategory' => $productsByCategory,
        ]);
    }

    /**
     * Detail produk. Port dari pages/product-detail.php.
     */
    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('products.show', [
            'product' => $product,
        ]);
    }
}
