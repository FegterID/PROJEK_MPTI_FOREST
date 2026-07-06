<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Katalog layanan publik, dikelompokkan per kategori.
     * Port dari pages/services.php.
     */
    public function index(): View
    {
        $categoryMeta = [
            'hair' => ['label' => 'Hair Care', 'title' => 'Perawatan Rambut'],
            'face' => ['label' => 'Face Care', 'title' => 'Perawatan Wajah'],
            'nail' => ['label' => 'Nail Care', 'title' => 'Perawatan Kuku'],
        ];

        $servicesByCategory = Service::orderBy('id')
            ->get()
            ->groupBy('category');

        return view('services.index', [
            'categoryMeta' => $categoryMeta,
            'servicesByCategory' => $servicesByCategory,
        ]);
    }
}
