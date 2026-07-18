@extends('layouts.admin')

@section('title', 'Menu Utama')

@section('content')
<!-- SUB-HEADER INFORMASIONAL -->
<div class="mb-6">
    <p class="text-xs text-ink-muted">Selamat datang kembali. Berikut adalah rangkuman performa operasional toko dan layanan Anda hari ini.</p>
</div>

<!-- TOP STATS CARDS -->
<div class="grid gap-6 sm:grid-cols-3">
    <!-- Card 1: Pending Orders -->
    <article class="relative group rounded-2xl border border-line bg-surface p-6 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.03)] hover:-translate-y-0.5">
        <div class="flex items-center justify-between">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-muted/80">Pending Bookings</p>
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-medium tracking-wide transition-colors duration-200 {{ $pendingOrders > 0 ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/10' : 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10' }}">
                <span class="mr-1 h-1 w-1 rounded-full {{ $pendingOrders > 0 ? 'bg-amber-500 animate-pulse' : 'bg-emerald-500' }}"></span>
                {{ $pendingOrders > 0 ? 'Action Required' : 'All Clear' }}
            </span>
        </div>
        <p class="mt-4 text-4xl font-bold tracking-tight text-ink">{{ str_pad($pendingOrders, 2, '0', STR_PAD_LEFT) }}</p>
        <p class="mt-2 text-[11px] text-ink-muted">Sesi antrean layanan menunggu konfirmasi admin.</p>
    </article>

    <!-- Card 2: Low Stock Alert -->
    <article class="relative group rounded-2xl border border-line bg-surface p-6 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.03)] hover:-translate-y-0.5">
        <div class="flex items-center justify-between">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-muted/80">Low Stock Alert</p>
            <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-0.5 text-[10px] font-medium tracking-wide text-rose-700 ring-1 ring-rose-600/10">
                {{ $lowStockPct }}
            </span>
        </div>
        <p class="mt-4 text-4xl font-bold tracking-tight text-ink">{{ str_pad($lowStockAlert, 2, '0', STR_PAD_LEFT) }}</p>
        <p class="mt-2 text-[11px] text-ink-muted">Item ritel dengan jumlah sisa stok &le; 5 unit.</p>
    </article>

    <!-- Card 3: Monthly Revenue -->
    <article class="relative overflow-hidden rounded-2xl bg-ink p-6 text-white shadow-lg shadow-ink/5 ring-1 ring-white/10">
        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/[0.03] blur-2xl pointer-events-none"></div>
        <div class="flex items-center justify-between">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-white/60">Monthly Revenue</p>
            <span class="inline-block rounded-full bg-white/10 px-2.5 py-0.5 text-[10px] font-medium tracking-wide backdrop-blur-sm">
                {{ $growthLabel }}
            </span>
        </div>
        <p class="mt-4 text-3xl font-bold tracking-tight">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
        <p class="mt-3 text-[11px] text-white/50 border-t border-white/10 pt-2.5">Akumulasi pendapatan mtd terkonfirmasi.</p>
    </article>
</div>

<!-- MIDDLE GRAPHICS SECTION -->
<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <!-- Chart 1: Analytics Booking -->
    <article class="rounded-2xl border border-line bg-surface p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h3 class="font-serif text-base font-semibold text-ink tracking-tight">Booking 7 Hari Terakhir</h3>
            <span class="text-[10px] text-ink-muted bg-surface-light px-2 py-0.5 rounded-md font-medium">Live Metrics</span>
        </div>
        <div class="mt-8 flex items-end gap-3.5" style="height: 150px;">
            @foreach ($weeklyBookings as $day)
                @php $height = max(6, round(($day['value'] / $maxWeekly) * 100)); @endphp
                <div class="flex flex-1 flex-col items-center justify-end gap-2.5 group h-full">
                    <div class="relative w-full rounded-t-lg bg-accent/80 group-hover:bg-accent transition-all duration-300" style="height: {{ $height }}%;">
                        <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-ink text-white text-[9px] font-medium px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none shadow-sm">
                            {{ $day['value'] }}
                        </div>
                    </div>
                    <span class="text-[9px] font-semibold uppercase tracking-wider text-ink-muted/80 group-hover:text-ink transition-colors duration-200">{{ $day['label'] }}</span>
                </div>
            @endforeach
        </div>
    </article>

    <!-- Chart 2: Popular Services -->
    <article class="rounded-2xl border border-line bg-surface p-6 shadow-sm">
        <h3 class="font-serif text-base font-semibold text-ink tracking-tight">Layanan Terpopuler (30 hari)</h3>
        @if ($servicePopularity->isEmpty())
            <div class="flex flex-col items-center justify-center h-full py-8 text-center">
                <p class="text-xs text-ink-muted">Belum ada riwayat data booking terekam.</p>
            </div>
        @else
            <div class="mt-6 space-y-4">
                @foreach ($servicePopularity as $service)
                    @php $pct = round(($service->total / $maxPopularity) * 100); @endphp
                    <div class="group">
                        <div class="flex justify-between text-xs font-medium text-ink-muted group-hover:text-ink transition-colors duration-200">
                            <span class="tracking-tight">{{ $service->service_name }}</span>
                            <span class="font-semibold text-ink/80">{{ $pct }}%</span>
                        </div>
                        <div class="mt-2 h-1.5 w-full rounded-full bg-surface-light overflow-hidden">
                            <div class="h-full rounded-full bg-accent transition-all duration-500" style="width: {{ max(4, $pct) }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </article>
</div>

<!-- BOTTOM DATA INTERFACES BLOCK -->
<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <!-- INTERFACE LEFT: RECENT BOOKINGS -->
    <div class="overflow-hidden rounded-2xl border border-line bg-surface shadow-sm transition-all duration-300">
        <div class="flex items-center justify-between border-b border-line px-6 py-4 bg-white/50 backdrop-blur-sm">
            <h3 class="font-serif text-base font-semibold text-ink tracking-tight">Booking Terbaru</h3>
            <a href="{{ route('admin.bookings.index') }}" class="group flex items-center gap-1 text-[11px] font-semibold text-accent tracking-wide hover:opacity-80 transition-opacity">
                Lihat Semua <span class="transform transition-transform group-hover:translate-x-0.5">&rarr;</span>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-surface-light/60 text-[10px] font-bold uppercase tracking-wider text-ink-muted/80 border-b border-line">
                    <tr>
                        <th class="px-6 py-3.5">Detail Pelanggan</th>
                        <th class="px-6 py-3.5">Nama Layanan</th>
                        <th class="px-6 py-3.5 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line/60">
                    @forelse ($recentBookings as $booking)
                        <tr class="hover:bg-surface-light/30 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <span class="block font-medium text-ink text-xs tracking-tight">{{ $booking->customer_name }}</span>
                                <span class="block text-[10px] text-ink-muted/80 mt-0.5">{{ $booking->booking_date->format('d M Y') }} &middot; {{ $booking->booking_time->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-ink-muted">{{ $booking->service_name }}</td>
                            <td class="px-6 py-4 text-right">
                                @php
                                    $status = method_exists($booking, 'statusLabel') ? $booking->statusLabel() : $booking->status;
                                    $statusClean = strtolower(trim(strip_tags($status)));
                                @endphp
                                <span class="inline-block px-2.5 py-0.5 text-[10px] font-medium rounded-full tracking-wide
                                    {{ str_contains($statusClean, 'pending') ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/10' : '' }}
                                    {{ str_contains($statusClean, 'paid') || str_contains($statusClean, 'confirm') || str_contains($statusClean, 'success') || str_contains($statusClean, 'selesai') ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10' : '' }}
                                    {{ !str_contains($statusClean, 'pending') && !str_contains($statusClean, 'paid') && !str_contains($statusClean, 'confirm') && !str_contains($statusClean, 'success') && !str_contains($statusClean, 'selesai') ? 'bg-zinc-50 text-zinc-600 ring-1 ring-zinc-500/10' : '' }}
                                ">
                                    {{ strip_tags($status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-xs text-ink-muted">Belum ada log antrean booking masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- INTERFACE RIGHT: RECENT PRODUCT ORDERS -->
    <div class="overflow-hidden rounded-2xl border border-line bg-surface shadow-sm transition-all duration-300">
        <div class="flex items-center justify-between border-b border-line px-6 py-4 bg-white/50 backdrop-blur-sm">
            <h3 class="font-serif text-base font-semibold text-ink tracking-tight">Pesanan Produk Terbaru</h3>
            <a href="{{ route('admin.orders.index') }}" class="group flex items-center gap-1 text-[11px] font-semibold text-accent tracking-wide hover:opacity-80 transition-opacity">
                Lihat Semua <span class="transform transition-transform group-hover:translate-x-0.5">&rarr;</span>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-surface-light/60 text-[10px] font-bold uppercase tracking-wider text-ink-muted/80 border-b border-line">
                    <tr>
                        <th class="px-6 py-3.5">Nomor Invoice</th>
                        <th class="px-6 py-3.5">Total Belanja</th>
                        <th class="px-6 py-3.5 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line/60">
                    @forelse ($recentOrders as $order)
                        <tr class="hover:bg-surface-light/30 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <span class="block font-mono text-xs font-semibold tracking-tight text-ink">{{ $order->order_number }}</span>
                                <span class="block text-[10px] text-ink-muted/80 mt-0.5">{{ $order->customer_name ?? 'Guest User' }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs font-bold text-ink">
                                Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                @php
                                    $orderStatus = strtolower(trim($order->status));
                                @endphp
                                <span class="inline-block px-2.5 py-0.5 text-[10px] font-semibold rounded-full uppercase tracking-wider
                                    {{ $orderStatus === 'pending' ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/10' : '' }}
                                    {{ $orderStatus === 'paid' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10' : '' }}
                                    {{ $orderStatus === 'completed' ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/10' : '' }}
                                    {{ !in_array($orderStatus, ['pending', 'paid', 'completed']) ? 'bg-zinc-50 text-zinc-600 ring-1 ring-zinc-500/10' : '' }}
                                ">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-xs text-ink-muted">Belum ada riwayat transaksi ritel masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
