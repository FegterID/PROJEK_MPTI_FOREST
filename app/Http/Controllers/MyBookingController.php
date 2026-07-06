<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MyBookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        $statusCounts = ['all' => $bookings->count()];
        foreach (Booking::STATUSES as $status) {
            $statusCounts[$status] = $bookings->where('status', $status)->count();
        }

        return view('booking.my-bookings', [
            'bookings' => $bookings,
            'statusCounts' => $statusCounts,
        ]);
    }
}
