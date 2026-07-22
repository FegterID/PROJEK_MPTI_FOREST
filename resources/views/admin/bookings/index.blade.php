@extends('layouts.admin')

@section('title', 'Booking List')

@section('content')
<!-- SUB-HEADER INFORMASIONAL -->
<div class="mb-6">
    <p class="text-xs text-ink-muted">Kelola seluruh antrean jadwal masuk, perbarui status layanan, dan pantau ringkasan omset operasional.</p>
</div>

<!-- RINGKASAN STATISTIK DENGAN SENTUHAN PREMIUM -->
<div class="mb-8 grid grid-cols-3 gap-6">
    <div class="rounded-2xl border border-line bg-surface p-5 text-center transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-muted/80">Menunggu</p>
        <p class="mt-2 text-2xl font-bold tracking-tight text-ink">{{ str_pad($totalPending, 2, '0', STR_PAD_LEFT) }}</p>
    </div>
    <div class="rounded-2xl border border-line bg-surface p-5 text-center transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-muted/80">Selesai</p>
        <p class="mt-2 text-2xl font-bold tracking-tight text-ink">{{ str_pad($totalCompleted, 2, '0', STR_PAD_LEFT) }}</p>
    </div>
    <div class="rounded-2xl border border-line bg-surface p-5 text-center transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-muted/80">Dibatalkan</p>
        <p class="mt-2 text-2xl font-bold tracking-tight text-ink">{{ str_pad($totalCancelled, 2, '0', STR_PAD_LEFT) }}</p>
    </div>
</div>

<!-- BAR ALAT: BARU - FITUR PENCARIAN DENGAN INTEGRASI FILTER KONSISTEN -->
<form method="GET" action="{{ route('admin.bookings.index') }}" class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center">
    <!-- Menjaga status filter badge tetap aktif saat form pencarian disubmit -->
    @if($filterStatus)
        <input type="hidden" name="status" value="{{ $filterStatus }}">
    @endif

    <!-- Input Search Box Component -->
    <div class="relative flex-1">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-ink-muted/70">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama pelanggan atau nomor WhatsApp..."
               class="w-full rounded-xl border border-line bg-surface pl-10 pr-4 py-2 text-xs font-medium text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
    </div>

    <!-- Action Button -->
    <button type="submit" class="rounded-xl bg-accent px-5 py-2 text-xs font-bold text-white shadow-sm shadow-accent/20 transition-all hover:opacity-90 active:scale-95">
        Cari Antrean
    </button>
</form>

<!-- FILTER STATUS BERBENTUK BADGE MODERN (DENGAN INPUT PENCARIAN TERJAGA) -->
<div class="mb-6 flex flex-wrap gap-2">
    <a href="{{ route('admin.bookings.index', request()->only(['q'])) }}"
       class="rounded-xl px-4 py-2 text-xs font-semibold tracking-wide transition-all duration-200
       {{ $filterStatus === '' ? 'bg-accent text-white shadow-sm shadow-accent/20' : 'border border-line bg-surface text-ink hover:border-accent' }}">
        Semua Data
    </a>
    @foreach ($statuses as $status)
        <a href="{{ route('admin.bookings.index', array_merge(request()->only(['q']), ['status' => $status])) }}"
           class="rounded-xl px-4 py-2 text-xs font-semibold tracking-wide transition-all duration-200
           {{ $filterStatus === $status ? 'bg-accent text-white shadow-sm shadow-accent/20' : 'border border-line bg-surface text-ink hover:border-accent' }}">
            {{ \App\Models\Booking::STATUS_LABELS[$status] }}
        </a>
    @endforeach
</div>

<!-- TABEL DATA INTERFACES KONSOL -->
<div class="overflow-hidden rounded-2xl border border-line bg-surface shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-surface-light/60 text-[10px] font-bold uppercase tracking-wider text-ink-muted/80 border-b border-line">
                <tr>
                    <th class="px-6 py-4">Detail Pelanggan</th>
                    <th class="px-6 py-4">Layanan</th>
                    <th class="px-6 py-4">Harga Layanan</th>
                    <th class="px-6 py-4">Jadwal Operasional</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line/60">
                @forelse ($bookings as $booking)
                    <tr class="hover:bg-surface-light/30 transition-colors duration-150">
                        <!-- Pelanggan -->
                        <td class="px-6 py-4">
                            <span class="block font-medium text-ink text-xs tracking-tight">{{ $booking->customer_name }}</span>
                            <span class="block font-mono text-[10px] text-ink-muted/80 mt-0.5">{{ $booking->whatsapp }}</span>
                        </td>

                        <!-- Layanan -->
                        <td class="px-6 py-4 text-xs font-medium text-ink-muted">
                            {{ $booking->service_name }}
                        </td>

                        <!-- HARGA LAYANAN -->
                        <td class="px-6 py-4 text-xs font-bold text-ink">
                            @if ($booking->price)
                                Rp {{ number_format($booking->price, 0, ',', '.') }}
                            @elseif ($booking->service?->price_range)
                                Rp {{ number_format((float) $booking->service->price_range, 0, ',', '.') }}
                            @elseif ($booking->service?->formattedPrice())
                                {{ $booking->service->formattedPrice() }}
                            @else
                                Rp {{ number_format($booking->service->price ?? 0, 0, ',', '.') }}
                            @endif
                        </td>

                        <!-- Jadwal -->
                        <td class="px-6 py-4 text-xs font-medium text-ink-muted">
                            <span class="block text-ink tracking-tight">{{ $booking->booking_date->format('d M Y') }}</span>
                            <span class="block text-[10px] text-ink-muted/80 mt-0.5">Pukul {{ $booking->booking_time->format('H:i') }} WIB</span>
                        </td>

                        <!-- Status Select (Custom Premium Style) -->
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                                @csrf
                                @method('PATCH')
                                <div class="relative inline-block w-full min-w-[120px]">
                                    <select name="status" onchange="this.form.submit()"
                                            class="w-full appearance-none rounded-xl border border-line bg-surface px-3 py-1.5 text-xs font-medium text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent pr-8">
                                        @foreach (\App\Models\Booking::STATUSES as $status)
                                            <option value="{{ $status }}" @selected($booking->status === $status)>
                                                {{ \App\Models\Booking::STATUS_LABELS[$status] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!-- Custom Dropdown Icon Arrow -->
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-ink-muted">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </form>
                        </td>

                        <!-- Aksi Hapus -->
                        <td class="px-6 py-4 text-right">
                            <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}"
                                  onsubmit="return confirm('Hapus entri booking #{{ $booking->id }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 rounded-xl border border-rose-200 bg-white px-3 py-1.5 text-xs font-medium text-rose-600 shadow-sm transition-all hover:bg-rose-50 hover:border-rose-300">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-xs text-ink-muted">Belum ada riwayat antrean antarmuka booking terekam.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- PAGINASI KUSTOM -->
<div class="mt-6">
    {{ $bookings->appends(request()->query())->links() }}
</div>
@endsection
