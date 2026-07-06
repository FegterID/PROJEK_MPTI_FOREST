@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="grid gap-5 sm:grid-cols-3">
    <article class="rounded-xl border border-line bg-surface p-5">
        <p class="text-xs font-medium uppercase tracking-wide text-ink-muted">Pending Orders</p>
        <p class="mt-2 text-3xl font-semibold text-ink">{{ str_pad($pendingOrders, 2, '0', STR_PAD_LEFT) }}</p>
        <span class="mt-3 inline-block rounded-full px-3 py-1 text-xs font-medium {{ $pendingOrders > 0 ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700' }}">
            {{ $pendingOrders > 0 ? 'Urgent' : 'Clear' }}
        </span>
        <p class="mt-1 text-xs text-ink-muted">Booking menunggu konfirmasi</p>
    </article>

    <article class="rounded-xl border border-line bg-surface p-5">
        <p class="text-xs font-medium uppercase tracking-wide text-ink-muted">Low Stock Alert</p>
        <p class="mt-2 text-3xl font-semibold text-ink">{{ str_pad($lowStockAlert, 2, '0', STR_PAD_LEFT) }}</p>
        <span class="mt-3 inline-block rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700">
            {{ $lowStockPct }}
        </span>
        <p class="mt-1 text-xs text-ink-muted">Produk stok &le; 5</p>
    </article>

    <article class="rounded-xl border border-line bg-ink p-5 text-white">
        <p class="text-xs font-medium uppercase tracking-wide text-white/60">Monthly Revenue</p>
        <p class="mt-2 text-3xl font-semibold">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
        <span class="mt-3 inline-block rounded-full bg-white/10 px-3 py-1 text-xs font-medium">{{ $growthLabel }}</span>
        <p class="mt-1 text-xs text-white/60">Month to date (dari booking terkonfirmasi/selesai)</p>
    </article>
</div>

<div class="mt-8 grid gap-5 lg:grid-cols-2">
    <article class="rounded-xl border border-line bg-surface p-5">
        <h3 class="font-serif text-lg font-semibold text-ink">Booking 7 Hari Terakhir</h3>
        <div class="mt-6 flex items-end gap-3" style="height: 140px;">
            @foreach ($weeklyBookings as $day)
                @php $height = max(8, round(($day['value'] / $maxWeekly) * 100)); @endphp
                <div class="flex flex-1 flex-col items-center justify-end gap-2" style="height: 100%;">
                    <div class="w-full rounded-t bg-accent" style="height: {{ $height }}%;"></div>
                    <span class="text-[10px] font-medium uppercase text-ink-muted">{{ $day['label'] }}</span>
                </div>
            @endforeach
        </div>
    </article>

    <article class="rounded-xl border border-line bg-surface p-5">
        <h3 class="font-serif text-lg font-semibold text-ink">Layanan Terpopuler (30 hari)</h3>
        @if ($servicePopularity->isEmpty())
            <p class="mt-4 text-sm text-ink-muted">Belum ada data booking.</p>
        @else
            <div class="mt-4 space-y-3">
                @foreach ($servicePopularity as $service)
                    @php $pct = round(($service->total / $maxPopularity) * 100); @endphp
                    <div>
                        <div class="flex justify-between text-xs text-ink-muted">
                            <span>{{ $service->service_name }}</span>
                            <span>{{ $pct }}%</span>
                        </div>
                        <div class="mt-1 h-2 rounded-full bg-surface-light">
                            <div class="h-2 rounded-full bg-accent" style="width: {{ max(4, $pct) }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </article>
</div>

<div class="mt-8 overflow-hidden rounded-xl border border-line bg-surface">
    <div class="flex items-center justify-between border-b border-line px-5 py-4">
        <h3 class="font-serif text-lg font-semibold text-ink">Booking Terbaru</h3>
        <a href="{{ route('admin.bookings.index') }}" class="text-xs font-medium text-accent hover:underline">Lihat semua &rarr;</a>
    </div>
    <table class="w-full text-left text-sm">
        <thead class="bg-surface-light text-xs uppercase tracking-wide text-ink-muted">
            <tr>
                <th class="px-4 py-3">Pelanggan</th>
                <th class="px-4 py-3">Layanan</th>
                <th class="px-4 py-3">Jadwal</th>
                <th class="px-4 py-3">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-line">
            @forelse ($recentBookings as $booking)
                <tr>
                    <td class="px-4 py-3 text-ink">{{ $booking->customer_name }}</td>
                    <td class="px-4 py-3 text-ink-muted">{{ $booking->service_name }}</td>
                    <td class="px-4 py-3 text-ink-muted">{{ $booking->booking_date->format('d M Y') }}, {{ $booking->booking_time->format('H:i') }}</td>
                    <td class="px-4 py-3 text-ink-muted">{{ $booking->statusLabel() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-10 text-center text-ink-muted">Belum ada booking.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
