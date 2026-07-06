<?php

// Pengganti $siteConfig pada project PHP native (includes/config.php).
// Diakses via config('site.xxx') atau lewat $siteConfig yang di-share
// ke semua view oleh App\Providers\AppServiceProvider.

return [
    'name' => env('APP_NAME', 'Septyaa Beauty Bar'),
    'phone' => env('SITE_PHONE', '+62 812-3456-7890'),
    'address' => env('SITE_ADDRESS', 'Jl. Melati No. 12, Jakarta'),
    'instagram' => env('SITE_INSTAGRAM', 'https://instagram.com/septyaabeautybar'),
    'whatsapp' => env('SITE_WHATSAPP', 'https://wa.me/6281234567890'),
];
