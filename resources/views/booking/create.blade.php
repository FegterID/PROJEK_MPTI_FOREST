@extends('layouts.app')

@section('title', 'Booking')

@section('content')
<section class="mx-auto max-w-5xl px-6 py-16">
    @guest
        <div class="mx-auto max-w-md rounded-xl border border-line bg-surface p-8 text-center">
            <h1 class="font-serif text-2xl font-semibold text-ink">Reservasi Layanan</h1>
            <p class="mt-2 text-sm text-ink-muted">Anda harus login terlebih dahulu untuk melakukan reservasi.</p>
            <a href="{{ route('login') }}"
               class="mt-5 inline-block rounded-full bg-accent px-6 py-3 text-sm font-medium text-white hover:bg-accent-dark">
                Masuk ke Akun
            </a>
            <p class="mt-4 text-sm text-ink-muted">
                Belum punya akun? <a href="{{ route('register') }}" class="text-accent hover:underline">Daftar di sini</a>
            </p>
        </div>
    @else
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-accent">Book Your Session</p>
        <h1 class="mt-2 font-serif text-3xl font-semibold text-ink">Reservasi Perawatan</h1>
        <p class="mt-2 text-sm text-ink-muted">
            Isi jadwal yang Anda inginkan. Tim kami akan menghubungi Anda untuk konfirmasi akhir.
        </p>

        @if (session('success'))
            <div class="mt-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="mt-8 grid gap-8 lg:grid-cols-[280px_1fr]">
            <aside class="space-y-4">
                <div class="rounded-xl border border-line bg-surface p-5">
                    <h3 class="text-sm font-semibold text-ink">Layanan Dipilih</h3>
                    <p class="mt-1 text-sm text-accent">{{ $selectedService !== '' ? $selectedService : 'Pilih layanan yang Anda inginkan' }}</p>
                    <a href="{{ route('services.index') }}" class="mt-2 inline-block text-xs text-ink-muted hover:text-accent">
                        Lihat katalog layanan &rarr;
                    </a>
                </div>

                <div class="rounded-xl border border-line bg-surface p-5">
                    <p class="text-sm font-semibold text-ink">Lokasi Salon</p>
                    <p class="mt-1 text-sm text-ink-muted">{{ config('site.address') }}</p>
                    <a href="https://maps.google.com/?q={{ urlencode(config('site.address')) }}" target="_blank" rel="noopener"
                       class="mt-2 inline-block text-xs text-accent hover:underline">
                        Buka di Google Maps
                    </a>
                </div>

                <div class="rounded-xl border border-line bg-surface p-5 text-sm text-ink-muted">
                    <p class="font-semibold text-ink">Alur cepat:</p>
                    <ol class="mt-2 list-inside list-decimal space-y-1">
                        <li>Lengkapi nama dan WhatsApp aktif.</li>
                        <li>Pilih tanggal serta jam kunjungan.</li>
                        <li>Kirim reservasi, admin konfirmasi jadwal.</li>
                    </ol>
                </div>
            </aside>

            <form method="POST" action="{{ route('booking.store') }}" class="space-y-5 rounded-xl border border-line bg-surface p-6">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Nama</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                               class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">No. WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->username) }}" placeholder="08xxxxxxxxxx" required
                               class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Layanan</label>
                    <select name="service" required
                            class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                        <option value="">Pilih layanan</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->name }}" @selected(old('service', $selectedService) === $service->name)>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Tanggal</label>
                        <input type="date" name="date" id="bookingDate" min="{{ now()->toDateString() }}"
                               value="{{ old('date', now()->toDateString()) }}" required
                               class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Jam</label>
                        <div id="slotGrid" class="mt-2 grid grid-cols-3 gap-2">
                            @foreach ($timeSlots as $slot)
                                <button type="button" data-slot="{{ $slot }}"
                                        class="slot-btn rounded-lg border border-line px-2 py-2 text-xs font-medium text-ink transition hover:border-accent">
                                    {{ $slot }}
                                </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="time" id="bookingTime" value="{{ old('time') }}" required>
                        <p id="slotHelp" class="mt-2 text-xs text-ink-muted">Pilih jam kunjungan yang tersedia.</p>
                    </div>
                </div>

                <button type="submit" class="w-full rounded-full bg-accent py-3 text-sm font-medium text-white hover:bg-accent-dark">
                    Kirim Reservasi
                </button>
                <p class="text-center text-xs text-ink-muted">Data reservasi langsung tersimpan ke database.</p>
            </form>
        </div>

        <script>
            (function () {
                const dateInput = document.getElementById('bookingDate');
                const timeInput = document.getElementById('bookingTime');
                const slotButtons = document.querySelectorAll('.slot-btn');
                const slotHelp = document.getElementById('slotHelp');

                function markActive(slot) {
                    slotButtons.forEach((btn) => {
                        btn.classList.toggle('bg-accent', btn.dataset.slot === slot);
                        btn.classList.toggle('text-white', btn.dataset.slot === slot);
                        btn.classList.toggle('border-accent', btn.dataset.slot === slot);
                    });
                }

                async function loadSlots() {
                    if (!dateInput.value) return;
                    slotHelp.textContent = 'Memuat slot...';

                    try {
                        const res = await fetch(`{{ route('booking.slots') }}?date=${dateInput.value}`);
                        const data = await res.json();
                        const booked = data.booked || [];

                        slotButtons.forEach((btn) => {
                            const isBooked = booked.includes(btn.dataset.slot);
                            btn.disabled = isBooked;
                            btn.classList.toggle('opacity-40', isBooked);
                            btn.classList.toggle('cursor-not-allowed', isBooked);
                        });

                        slotHelp.textContent = 'Pilih jam kunjungan yang tersedia.';
                    } catch (e) {
                        slotHelp.textContent = 'Gagal memuat slot, silakan coba lagi.';
                    }
                }

                slotButtons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        if (btn.disabled) return;
                        timeInput.value = btn.dataset.slot;
                        markActive(btn.dataset.slot);
                    });
                });

                dateInput.addEventListener('change', loadSlots);
                loadSlots();
                if (timeInput.value) markActive(timeInput.value);
            })();
        </script>
    @endguest
</section>
@endsection
