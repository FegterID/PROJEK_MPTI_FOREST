<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MyBookingController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. Ambil data pesanan produk milik user yang sedang login
        $orders = \App\Models\Order::with('items.product')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->get();

        // 2. Ambil data booking milik user yang sedang login
        $bookings = \App\Models\Booking::where('user_id', $user->id)
                    ->latest()
                    ->get();

        // 3. Logika perhitungan status booking untuk summary box
        $statusCounts = [
            'all'       => $bookings->count(),
            'pending'   => $bookings->where('status', 'pending')->count(),
            'confirmed' => $bookings->where('status', 'confirmed')->count(),
            'completed' => $bookings->where('status', 'completed')->count(),
        ];

        // 4. Arahkan ke file view riwayat gabungan yang baru
        return view('history.index', compact('orders', 'bookings', 'statusCounts'));
    }
}
