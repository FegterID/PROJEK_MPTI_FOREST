<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Port dari pages/admin/dashboard.php. Query month-over-month revenue
     * & grafik mingguan disederhanakan (tanpa JOIN service price yang agak
     * rapuh di versi asli), tapi angka intinya sama.
     */
    public function index(): View
    {
        $pendingOrders = Booking::where('status', 'pending')->count();
        $lowStockAlert = Product::where('is_active', true)->where('stock', '<=', 5)->count();
        $totalActiveProducts = Product::where('is_active', true)->count();

        $lowStockPct = $totalActiveProducts > 0 && $lowStockAlert > 0
            ? '-'.round(($lowStockAlert / $totalActiveProducts) * 100).'%'
            : '0%';

        $monthlyRevenue = $this->revenueForMonth(now());
        $lastMonthRevenue = $this->revenueForMonth(now()->subMonthNoOverflow());

        $revenueGrowthPct = $lastMonthRevenue > 0
            ? (int) round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100)
            : 0;
        $growthLabel = ($revenueGrowthPct >= 0 ? '+' : '').$revenueGrowthPct.'%';

        $weeklyBookings = collect(range(6, 0))->map(function (int $daysAgo) {
            $date = now()->subDays($daysAgo);

            return [
                'label' => $date->translatedFormat('D'),
                'value' => Booking::whereDate('booking_date', $date->toDateString())->count(),
            ];
        });
        $maxWeekly = max(1, $weeklyBookings->max('value'));

        $servicePopularity = Booking::select('service_name', DB::raw('COUNT(*) as total'))
            ->where('booking_date', '>=', now()->subDays(30))
            ->groupBy('service_name')
            ->orderByDesc('total')
            ->limit(4)
            ->get();
        $maxPopularity = max(1, (int) ($servicePopularity->max('total') ?? 1));

        $recentBookings = Booking::orderByDesc('id')->limit(8)->get();

        return view('admin.dashboard', [
            'pendingOrders' => $pendingOrders,
            'lowStockAlert' => $lowStockAlert,
            'lowStockPct' => $lowStockPct,
            'monthlyRevenue' => $monthlyRevenue,
            'growthLabel' => $growthLabel,
            'weeklyBookings' => $weeklyBookings,
            'maxWeekly' => $maxWeekly,
            'servicePopularity' => $servicePopularity,
            'maxPopularity' => $maxPopularity,
            'recentBookings' => $recentBookings,
            'totalServices' => Service::count(),
        ]);
    }

    private function revenueForMonth(Carbon $month): int
    {
        return (int) Booking::whereIn('bookings.status', ['confirmed', 'completed'])
            ->whereYear('bookings.booking_date', $month->year)
            ->whereMonth('bookings.booking_date', $month->month)
            ->join('services', 'services.name', '=', 'bookings.service_name')
            ->sum('services.price');
    }
}
