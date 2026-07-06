@extends('layouts.admin')

@section('title', 'Kelola Layanan')

@section('content')
@php
    $form = $editingService;
    $priceType = old('price_type', $form && $form->price_range ? 'range' : 'fixed');
@endphp

<div class="grid gap-8 lg:grid-cols-[1fr_360px]">
    {{-- Tabel layanan --}}
    <div class="overflow-hidden rounded-xl border border-line bg-surface">
        <table class="w-full text-left text-sm">
            <thead class="bg-surface-light text-xs uppercase tracking-wide text-ink-muted">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Durasi</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($services as $service)
                    <tr class="{{ $editingService?->id === $service->id ? 'bg-accent/5' : '' }}">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($service->imageUrl())
                                    <img src="{{ $service->imageUrl() }}" alt="{{ $service->name }}" class="h-10 w-10 shrink-0 rounded-lg border border-line object-cover">
                                @else
                                    <div class="h-10 w-10 shrink-0 rounded-lg bg-surface-light"></div>
                                @endif
                                <div>
                                    <p class="font-medium text-ink">{{ $service->name }}</p>
                                    <p class="text-xs text-ink-muted line-clamp-1">{{ $service->description }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-ink-muted">{{ $service->category_name }}</td>
                        <td class="px-4 py-3 text-ink-muted">{{ $service->duration }} mnt</td>
                        <td class="px-4 py-3 text-ink-muted">{{ $service->formattedPrice() }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.services.index', ['edit' => $service->id]) }}"
                                   class="rounded-md border border-line px-3 py-1.5 text-xs font-medium text-ink hover:border-accent hover:text-accent">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                                      onsubmit="return confirm('Hapus layanan {{ $service->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="rounded-md border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-ink-muted">Belum ada layanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Form tambah/edit --}}
    <div class="h-fit rounded-xl border border-line bg-surface p-5">
        <h2 class="font-serif text-lg font-semibold text-ink">
            {{ $editingService ? 'Edit Layanan' : 'Tambah Layanan' }}
        </h2>

        @if ($errors->any())
            <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ $editingService ? route('admin.services.update', $editingService) : route('admin.services.store') }}"
              enctype="multipart/form-data"
              class="mt-4 space-y-4">
            @csrf
            @if ($editingService) @method('PUT') @endif

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Gambar Layanan</label>
                @if ($editingService?->image)
                    <img src="{{ $editingService->imageUrl() }}" alt="{{ $editingService->name }}"
                         class="mt-2 h-24 w-24 rounded-lg border border-line object-cover">
                @endif
                <input type="file" name="image" accept="image/*"
                       class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-accent/10 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-accent">
                <p class="mt-1 text-xs text-ink-muted">JPG/PNG/WebP, maks 2MB. {{ $editingService ? 'Kosongkan kalau tidak ingin ganti gambar.' : '' }}</p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Nama Layanan</label>
                <input type="text" name="name" value="{{ old('name', $form->name ?? '') }}" required
                       class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Kategori</label>
                <select name="category" required
                        class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                    @foreach ($validCategories as $category)
                        <option value="{{ $category }}" @selected(old('category', $form->category ?? '') === $category)>
                            {{ \App\Models\Service::CATEGORY_LABELS[$category] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Deskripsi</label>
                <textarea name="description" rows="3" required
                          class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">{{ old('description', $form->description ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Durasi (menit)</label>
                <input type="number" name="duration" min="1" value="{{ old('duration', $form->duration ?? '') }}" required
                       class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Tipe Harga</label>
                <div class="mt-2 flex gap-4 text-sm">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="price_type" value="fixed" {{ $priceType === 'fixed' ? 'checked' : '' }}
                               onchange="document.getElementById('price-fixed').classList.remove('hidden'); document.getElementById('price-range').classList.add('hidden');">
                        Tetap
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="price_type" value="range" {{ $priceType === 'range' ? 'checked' : '' }}
                               onchange="document.getElementById('price-range').classList.remove('hidden'); document.getElementById('price-fixed').classList.add('hidden');">
                        Mulai dari
                    </label>
                </div>
            </div>

            <div id="price-fixed" class="{{ $priceType === 'range' ? 'hidden' : '' }}">
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Harga (Rp)</label>
                <input type="number" name="price" min="0" value="{{ old('price', $form->price ?? '') }}"
                       class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
            </div>

            <div id="price-range" class="{{ $priceType === 'fixed' ? 'hidden' : '' }}">
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Rentang Harga</label>
                <input type="text" name="price_range" placeholder="mis. 350000" value="{{ old('price_range', $form->price_range ?? '') }}"
                       class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 rounded-lg bg-accent py-2.5 text-sm font-medium text-white hover:bg-accent-dark">
                    {{ $editingService ? 'Update' : 'Simpan' }}
                </button>
                @if ($editingService)
                    <a href="{{ route('admin.services.index') }}"
                       class="rounded-lg border border-line px-4 py-2.5 text-sm font-medium text-ink hover:border-accent">
                        Batal
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
