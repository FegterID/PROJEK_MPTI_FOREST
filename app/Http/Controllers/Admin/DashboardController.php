<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Product;
use App\Models\Service;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // 1. Akumulasi Pendapatan Bulan Ini (Layanan + Produk Ritel)
        // Memakai JOIN ke tabel services untuk mengambil data kolom 'price' yang valid
        $serviceRevenue = Booking::whereIn('bookings.status', ['paid', 'confirmed', 'success', 'completed'])
            ->whereBetween('bookings.booking_date', [$startOfMonth, $endOfMonth])
            ->join('services', 'services.name', '=', 'bookings.service_name')
            ->sum('services.price');

        $productRevenue = Order::whereIn('status', ['paid', 'completed'])
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total');

        $monthlyRevenue = $serviceRevenue + $productRevenue;

        // 2. Hitung Growth MoM (Month-over-Month) Gabungan
        $currentMonthRevenue = $this->revenueForMonth(Carbon::now());
        $lastMonthRevenue = $this->revenueForMonth(Carbon::now()->subMonth());

        if ($lastMonthRevenue > 0) {
            $growth = (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
            $growthLabel = ($growth >= 0 ? '+' : '') . round($growth, 1) . '%';
        } else {
            $growthLabel = '+0%';
        }

        // 3. Top Stats Cards Data
        $pendingOrders = Booking::where('status', 'pending')->count();

        $totalProducts = Product::count();
        $lowStockAlert = Product::where('stock', '<=', 5)->count();
        $lowStockPct = $totalProducts > 0 ? round(($lowStockAlert / $totalProducts) * 100) . '%' : '0%';

        // 4. Grafik Booking 7 Hari Terakhir
        $weeklyBookings = [];
        $maxWeekly = 1;

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = Booking::whereDate('booking_date', $date->toDateString())->count();

            $weeklyBookings[] = [
                'label' => strtoupper($date->isoFormat('ddd')),
                'value' => $count
            ];

            if ($count > $maxWeekly) {
                $maxWeekly = $count;
            }
        }

        // 5. Layanan Terpopuler (30 Hari Terakhir)
        $servicePopularity = Booking::select('service_name', DB::raw('count(*) as total'))
            ->where('booking_date', '>=', Carbon::now()->subDays(30))
            ->groupBy('service_name')
            ->orderByDesc('total')
            ->take(4)
            ->get();

        $maxPopularity = $servicePopularity->max('total') ?? 1;

        // 6. Data Tabel Terbaru
        $recentBookings = Booking::orderByDesc('created_at')->take(5)->get();
        $recentOrders = Order::orderByDesc('created_at')->take(5)->get();

        return view('admin.dashboard', compact(
            'monthlyRevenue',
            'pendingOrders',
            'lowStockAlert',
            'lowStockPct',
            'growthLabel',
            'weeklyBookings',
            'maxWeekly',
            'servicePopularity',
            'maxPopularity',
            'recentBookings',
            'recentOrders'
        ));
    }

    /**
     * Helper untuk menghitung total pendapatan gabungan pada bulan tertentu
     */
    private function revenueForMonth(Carbon $month): int
    {
        $services = (int) Booking::whereIn('bookings.status', ['paid', 'confirmed', 'success', 'completed'])
            ->whereYear('bookings.booking_date', $month->year)
            ->whereMonth('bookings.booking_date', $month->month)
            ->join('services', 'services.name', '=', 'bookings.service_name')
            ->sum('services.price');

        $products = (int) Order::whereIn('status', ['paid', 'completed'])
            ->whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->sum('total');

        return $services + $products;
    }
}
