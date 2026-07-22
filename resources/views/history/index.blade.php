@extends('layouts.app')

@section('title', 'Riwayat Pesanan & Booking')

@section('content')
<section class="mx-auto max-w-5xl px-6 py-16">
    <h1 class="font-serif text-3xl font-semibold text-ink">Riwayat Pesanan</h1>
    <p class="mt-2 text-sm text-ink-muted">
        Selamat datang, <strong class="text-ink">{{ auth()->user()->name }}</strong>. Pantau transaksi produk dan jadwal treatment Anda di sini.
    </p>

    @php
        // Mengambil tab aktif dari URL query parameter, default ke 'products'
        $activeTab = request('tab', 'products');
    @endphp

    <!-- TAB NAVIGASI -->
    <div class="mt-8 flex border-b border-line">
        <!-- Menggunakan route 'bookings.mine' sesuai web.php -->
        <a href="{{ route('bookings.mine', ['tab' => 'products']) }}"
           class="border-b-2 px-6 py-3 text-sm transition-all duration-200 focus:outline-none {{ $activeTab === 'products' ? 'border-accent text-accent font-semibold' : 'border-transparent text-ink-muted hover:text-ink' }}">
            Belanja Produk
        </a>
        <a href="{{ route('bookings.mine', ['tab' => 'bookings']) }}"
           class="border-b-2 px-6 py-3 text-sm transition-all duration-200 focus:outline-none {{ $activeTab === 'bookings' ? 'border-accent text-accent font-semibold' : 'border-transparent text-ink-muted hover:text-ink' }}">
            Reservasi Booking
        </a>
    </div>

    <!-- KONTEN TAB: BELANJA PRODUK -->
    @if($activeTab === 'products')
        <div class="mt-6 space-y-6">
            @if ($orders->isEmpty())
                <div class="rounded-xl border border-dashed border-line p-10 text-center text-ink-muted">
                    Anda belum pernah melakukan transaksi produk.
                    <a href="{{ route('products.index') }}" class="text-accent hover:underline">Mulai belanja sekarang</a>
                </div>
            @else
                @foreach ($orders as $order)
                    @php
                        $orderStatusColor = match ($order->status) {
                            'paid' => 'bg-blue-50 text-blue-700 border border-blue-200',
                            'completed' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                            'cancelled' => 'bg-red-50 text-red-700 border border-red-200',
                            default => 'bg-amber-50 text-amber-700 border border-amber-200',
                        };
                    @endphp
                    <article class="rounded-xl border border-line bg-surface p-6 shadow-sm transition-all hover:shadow-md">
                        <!-- Header Card: No Invoice, Tanggal & Status -->
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between border-b border-line pb-4">
                            <div class="flex items-center gap-4">
                                <div>
                                    <p class="text-xs text-ink-muted uppercase tracking-wider">No. Invoice</p>
                                    <p class="text-base font-semibold text-ink">{{ $order->order_number }}</p>
                                </div>
                                <div class="hidden h-8 w-px bg-line sm:block"></div>
                                <div>
                                    <p class="text-xs text-ink-muted">Waktu Transaksi</p>
                                    <p class="text-sm text-ink font-medium">{{ $order->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                                </div>
                            </div>
                            <div>
                                <span class="inline-block rounded-full px-4 py-1 text-xs font-semibold uppercase tracking-wide {{ $orderStatusColor }}">
                                    {{ $order->statusLabel() }}
                                </span>
                            </div>
                        </div>

                        <!-- Body Card: List Detail Semua Item Belanjaan -->
                        <div class="divide-y divide-line/60">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between py-4 first:pt-4 last:pb-0">
                                    <div class="flex items-center gap-4">
                                        <!-- Gambar Mini Produk (Ganti asset path sesuai struktur folder Anda) -->
                                        <div class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-lg border border-line bg-line/10">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="flex h-full w-full items-center justify-center bg-line/30 text-xs text-ink-muted">No Image</div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-ink">{{ $item->product->name ?? 'Produk Telah Dihapus' }}</h4>
                                            <p class="mt-0.5 text-xs text-ink-muted">
                                                {{ $item->quantity }} barang x Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-ink-muted">Subtotal</p>
                                        <p class="text-sm font-medium text-ink">Rp {{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Footer Card: Total Pembayaran Keseluruhan -->
                        <div class="mt-4 flex flex-col items-end justify-between gap-3 border-t border-line/60 pt-4 sm:flex-row sm:items-center">
                            <span class="text-xs text-ink-muted">
                                Total Kuantitas: <strong class="text-ink font-medium">{{ $order->items->sum('quantity') }} produk</strong>
                            </span>
                            <div class="text-right">
                                <span class="text-xs text-ink-muted block mb-0.5">Total Pembayaran</span>
                                <span class="text-lg font-bold text-accent">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            @endif
        </div>
    @endif

    <!-- KONTEN TAB: RESERVASI BOOKING -->
    @if($activeTab === 'bookings')
        <div class="mt-6">
            <div class="mb-4 flex justify-between items-center">
                <h2 class="text-lg font-serif font-semibold text-ink">Jadwal Perawatan</h2>
                <a href="{{ route('booking.create') }}"
                   class="inline-block rounded-full bg-accent px-4 py-2 text-xs font-medium text-white hover:bg-accent-dark">
                    + Reservasi Baru
                </a>
            </div>

            @if ($bookings->isEmpty())
                <div class="rounded-xl border border-dashed border-line p-10 text-center text-ink-muted">
                    Anda belum memiliki riwayat booking.
                    <a href="{{ route('booking.create') }}" class="text-accent hover:underline">Buat booking sekarang</a>
                </div>
            @else
                <div class="mb-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
                    <div class="rounded-xl border border-line bg-surface p-4 text-center">
                        <p class="text-xs text-ink-muted">Total Booking</p>
                        <p class="mt-1 text-xl font-semibold text-ink">{{ $statusCounts['all'] ?? $bookings->count() }}</p>
                    </div>
                    <div class="rounded-xl border border-line bg-surface p-4 text-center">
                        <p class="text-xs text-ink-muted">Menunggu</p>
                        <p class="mt-1 text-xl font-semibold text-ink">{{ $statusCounts['pending'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-line bg-surface p-4 text-center">
                        <p class="text-xs text-ink-muted">Dikonfirmasi</p>
                        <p class="mt-1 text-xl font-semibold text-ink">{{ $statusCounts['confirmed'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-line bg-surface p-4 text-center">
                        <p class="text-xs text-ink-muted">Selesai</p>
                        <p class="mt-1 text-xl font-semibold text-ink">{{ $statusCounts['completed'] ?? 0 }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach ($bookings as $booking)
                        @php
                            $bookingStatusColor = match ($booking->status) {
                                'confirmed' => 'bg-blue-50 text-blue-700',
                                'completed' => 'bg-emerald-50 text-emerald-700',
                                'cancelled' => 'bg-red-50 text-red-700',
                                default => 'bg-amber-50 text-amber-700',
                            };
                        @endphp
                        <article class="rounded-xl border border-line bg-surface p-5">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-ink-muted">Booking #{{ $booking->id }}</p>
                                <span class="rounded-full px-3 py-1 text-xs font-medium {{ $bookingStatusColor }}">{{ $booking->statusLabel() }}</span>
                            </div>
                            <h3 class="mt-2 font-serif text-lg font-semibold text-ink">{{ $booking->service_name }}</h3>

                            <div class="mt-3 grid grid-cols-4 gap-4 text-sm">
                                <div>
                                    <p class="text-xs text-ink-muted">Tanggal</p>
                                    <p class="text-ink">{{ $booking->booking_date->translatedFormat('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-ink-muted">Jam</p>
                                    <p class="text-ink">{{ $booking->booking_time->format('H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-ink-muted">Harga</p>
                                    <p class="text-ink">{{ $booking->display_price }}</p>
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
        </div>
    @endif
</section>
@endsection
