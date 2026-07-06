@extends('layouts.app')

@section('title', 'Riwayat Booking')

@section('content')
<section class="mx-auto max-w-5xl px-6 py-16">
    <h1 class="font-serif text-3xl font-semibold text-ink">Riwayat Booking</h1>
    <p class="mt-2 text-sm text-ink-muted">
        Selamat datang, <strong class="text-ink">{{ auth()->user()->name }}</strong>. Kelola jadwal treatment Anda dari sini.
    </p>
    <a href="{{ route('booking.create') }}"
       class="mt-4 inline-block rounded-full bg-accent px-5 py-2.5 text-sm font-medium text-white hover:bg-accent-dark">
        + Reservasi Baru
    </a>

    @if ($bookings->isEmpty())
        <div class="mt-10 rounded-xl border border-dashed border-line p-10 text-center text-ink-muted">
            Anda belum memiliki booking.
            <a href="{{ route('booking.create') }}" class="text-accent hover:underline">Buat booking sekarang</a>
        </div>
    @else
        <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-4">
            <div class="rounded-xl border border-line bg-surface p-4 text-center">
                <p class="text-xs text-ink-muted">Total Booking</p>
                <p class="mt-1 text-xl font-semibold text-ink">{{ $statusCounts['all'] }}</p>
            </div>
            <div class="rounded-xl border border-line bg-surface p-4 text-center">
                <p class="text-xs text-ink-muted">Menunggu</p>
                <p class="mt-1 text-xl font-semibold text-ink">{{ $statusCounts['pending'] }}</p>
            </div>
            <div class="rounded-xl border border-line bg-surface p-4 text-center">
                <p class="text-xs text-ink-muted">Dikonfirmasi</p>
                <p class="mt-1 text-xl font-semibold text-ink">{{ $statusCounts['confirmed'] }}</p>
            </div>
            <div class="rounded-xl border border-line bg-surface p-4 text-center">
                <p class="text-xs text-ink-muted">Selesai</p>
                <p class="mt-1 text-xl font-semibold text-ink">{{ $statusCounts['completed'] }}</p>
            </div>
        </div>

        <div class="mt-8 space-y-4">
            @foreach ($bookings as $booking)
                @php
                    $statusColor = match ($booking->status) {
                        'confirmed' => 'bg-blue-50 text-blue-700',
                        'completed' => 'bg-emerald-50 text-emerald-700',
                        'cancelled' => 'bg-red-50 text-red-700',
                        default => 'bg-amber-50 text-amber-700',
                    };
                @endphp
                <article class="rounded-xl border border-line bg-surface p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-ink-muted">Booking #{{ $booking->id }}</p>
                        <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusColor }}">{{ $booking->statusLabel() }}</span>
                    </div>
                    <h3 class="mt-2 font-serif text-lg font-semibold text-ink">{{ $booking->service_name }}</h3>

                    <div class="mt-3 grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-ink-muted">Tanggal</p>
                            <p class="text-ink">{{ $booking->booking_date->translatedFormat('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-ink-muted">Jam</p>
                            <p class="text-ink">{{ $booking->booking_time->format('H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-ink-muted">Dibuat</p>
                            <p class="text-ink">{{ $booking->created_at->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('booking.create', ['service' => $booking->service_name]) }}"
                           class="rounded-full bg-accent px-4 py-2 text-xs font-medium text-white hover:bg-accent-dark">
                            Pesan Lagi
                        </a>
                        <a href="{{ $booking->whatsappLink() }}" target="_blank" rel="noopener"
                           class="rounded-full border border-line px-4 py-2 text-xs font-medium text-ink hover:border-accent hover:text-accent">
                            Hubungi
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</section>
@endsection
