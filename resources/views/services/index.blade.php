@extends('layouts.app')

@section('title', 'Layanan')

@section('content')
<section class="mx-auto max-w-6xl px-6 py-16 text-center">
    <p class="text-xs font-medium uppercase tracking-[0.3em] text-accent">Layanan Kami</p>
    <h1 class="mt-3 font-serif text-3xl font-semibold text-ink sm:text-4xl">Pilih Layanan Favorit Anda</h1>
    <p class="mx-auto mt-4 max-w-xl text-sm text-ink-muted">
        Katalog layanan kami disusun per kategori supaya lebih mudah dibandingkan sebelum reservasi.
    </p>

    <div class="mt-6 flex flex-wrap justify-center gap-2 text-xs font-medium text-ink-muted">
        <span class="rounded-full border border-line px-3 py-1">Konsultasi Gratis</span>
        <span class="rounded-full border border-line px-3 py-1">Therapist Bersertifikat</span>
        <span class="rounded-full border border-line px-3 py-1">Produk Premium</span>
        <span class="rounded-full border border-line px-3 py-1">Bisa Langsung Reservasi</span>
    </div>
</section>

<section class="mx-auto max-w-6xl px-6 pb-20">
    @if ($servicesByCategory->isEmpty())
        <div class="rounded-xl border border-line bg-surface p-10 text-center text-ink-muted">
            Belum ada layanan tersedia saat ini.
        </div>
    @else
        @foreach ($categoryMeta as $categoryKey => $meta)
            @continue($servicesByCategory->get($categoryKey, collect())->isEmpty())

            <div class="mb-14">
                <h2 class="mb-5 font-serif text-xl font-semibold text-ink">{{ $meta['title'] }}</h2>

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($servicesByCategory[$categoryKey] as $service)
                        <div class="flex flex-col justify-between rounded-xl border border-line bg-surface p-5 transition hover:border-accent">
                            <div>
                                @if ($service->imageUrl())
                                    <img src="{{ $service->imageUrl() }}" alt="{{ $service->name }}"
                                         class="mb-3 h-40 w-full rounded-lg object-cover">
                                @endif
                                <span class="text-[11px] font-medium uppercase tracking-wide text-accent">{{ $meta['label'] }}</span>
                                <h3 class="mt-2 font-serif text-lg font-semibold text-ink">{{ $service->name }}</h3>
                                <p class="mt-2 text-sm text-ink-muted">{{ $service->description }}</p>
                            </div>

                            <div class="mt-5 flex items-center justify-between border-t border-line pt-4">
                                <div>
                                    <p class="font-semibold text-ink">{{ $service->formattedPrice() }}</p>
                                    <p class="text-xs text-ink-muted">{{ $service->duration }} menit</p>
                                </div>
                                <span class="rounded-full bg-surface-light px-3 py-1 text-xs text-ink-muted">
                                    Booking segera hadir
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</section>
@endsection
