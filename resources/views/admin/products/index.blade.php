@extends('layouts.admin')

@section('title', 'Manajemen Persediaan Produk')

@section('content')
<!-- SUB-HEADER INFORMASIONAL -->
<div class="mb-6">
    <p class="text-xs text-ink-muted">Pantau ketersediaan stok barang ritel, perbarui harga komoditas, serta kelola katalog produk aktif toko Anda.</p>
</div>

<!-- GRID SYSTEM LAYOUT UTAMA -->
<div class="grid gap-6 lg:grid-cols-[1fr_380px] items-start">

    {{-- SISI KIRI: TABEL DATA PRODUK PREMIUM --}}
    <div class="overflow-hidden rounded-2xl border border-line bg-surface shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-surface-light/60 text-[10px] font-bold uppercase tracking-wider text-ink-muted/80 border-b border-line">
                    <tr>
                        <th class="px-5 py-4">Detail Produk</th>
                        <th class="px-5 py-4">Kategori</th>
                        <th class="px-5 py-4">Harga Jual</th>
                        <th class="px-5 py-4 text-center">Stok</th>
                        <th class="px-5 py-4 text-center">Status Kontrol</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line/60">
                    @forelse ($products as $product)
                        <tr class="hover:bg-surface-light/30 transition-colors duration-150 {{ $editingProduct?->id === $product->id ? 'bg-accent/5' : '' }} {{ ! $product->is_active ? 'opacity-60 bg-surface-light/10' : '' }}">

                            <!-- Thumbnail & Keterangan Text -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3.5">
                                    @if ($product->imageUrl())
                                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="h-11 w-11 shrink-0 rounded-xl border border-line object-cover shadow-sm">
                                    @else
                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-surface-light text-ink-muted/50 border border-line">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    @endif
                                    <div class="max-w-xs">
                                        <p class="font-medium text-ink text-xs tracking-tight">{{ $product->name }}</p>
                                        <p class="text-[10px] text-ink-muted/80 mt-0.5 line-clamp-1" title="{{ $product->description }}">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori Badge -->
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-xl bg-accent/10 px-2.5 py-1 text-[10px] font-bold tracking-wide text-accent uppercase">
                                    {{ $product->category }}
                                </span>
                            </td>

                            <!-- Harga -->
                            <td class="px-5 py-4 text-xs font-semibold text-ink">
                                {{ $product->formattedPrice() }}
                            </td>

                            <!-- Status Indikator Stok -->
                            <td class="px-5 py-4 text-center">
                                @if($product->stock > 0)
                                    <span class="inline-flex items-center rounded-xl bg-emerald-50 px-2.5 py-1 text-[10px] font-bold tracking-wide text-emerald-700 border border-emerald-100">
                                        {{ $product->stock }} Item
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-xl bg-rose-50 px-2.5 py-1 text-[10px] font-bold tracking-wide text-rose-700 border border-rose-100">
                                        Habis
                                    </span>
                                @endif
                            </td>

                            <!-- Toggle Interaktif Status -->
                            <td class="px-5 py-4 text-center">
                                <form method="POST" action="{{ route('admin.products.toggle', $product) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="inline-flex items-center rounded-xl px-3 py-1.5 text-[10px] font-bold tracking-wide shadow-sm transition-all active:scale-95 text-white
                                            {{ $product->is_active ? 'bg-sky-600 hover:bg-sky-500 shadow-sky-600/10' : 'bg-ink-muted/60 hover:bg-ink-muted shadow-sm' }}">
                                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Kelompok Tombol Aksi -->
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.products.index', ['edit' => $product->id]) }}"
                                       class="inline-flex items-center gap-1 rounded-xl border border-line bg-surface px-3 py-1.5 text-xs font-medium text-ink shadow-sm transition-all hover:border-accent hover:text-accent">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                          onsubmit="return confirm('Hapus entri produk {{ $product->name }} dari sistem?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-xl border border-rose-200 bg-white px-3 py-1.5 text-xs font-medium text-rose-600 shadow-sm transition-all hover:bg-rose-50 hover:border-rose-300">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-xs text-ink-muted">Belum ada riwayat koleksi produk ritel tersimpan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SISI KANAN: FORM MANAGEMENT COMPONENT --}}
    <div class="h-fit rounded-2xl border border-line bg-surface p-5 shadow-sm">
        <h2 class="text-xs font-bold uppercase tracking-wider text-ink border-b border-line pb-3.5">
            {{ $editingProduct ? 'Edit Entri Produk #'.$editingProduct->id : 'Registrasi Produk Baru' }}
        </h2>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50/70 px-4 py-3 text-xs font-medium text-rose-700">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ $editingProduct ? route('admin.products.update', $editingProduct) : route('admin.products.store') }}"
              enctype="multipart/form-data"
              class="mt-4 space-y-4">
            @csrf
            @if ($editingProduct) @method('PUT') @endif

            <!-- Input Image File -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Unggah Gambar Produk</label>
                @if ($editingProduct?->image)
                    <div class="relative inline-block mt-2">
                        <img src="{{ $editingProduct->imageUrl() }}" alt="{{ $editingProduct->name }}"
                             class="h-20 w-20 rounded-xl border border-line object-cover shadow-sm">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                       class="mt-2 w-full rounded-xl border border-line bg-surface px-3 py-1.5 text-xs text-ink shadow-sm file:mr-3 file:rounded-lg file:border-0 file:bg-accent/10 file:px-3 file:py-1 file:text-[11px] file:font-bold file:text-accent file:transition-all hover:file:bg-accent/20 cursor-pointer">
                <p class="mt-1 text-[10px] text-ink-muted/80">Kompresi JPG, PNG, atau WebP (Maks. 2MB). {{ $editingProduct ? 'Biarkan kosong jika tetap menggunakan aset lama.' : '' }}</p>
            </div>

            <!-- Input Nama -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Nama Varian Produk</label>
                <input type="text" name="name" value="{{ old('name', $editingProduct->name ?? '') }}" required
                       class="mt-2 w-full rounded-xl border border-line bg-surface px-4 py-2 text-xs font-medium text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
            </div>

            <!-- Input Kategori -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Kategori Klasifikasi</label>
                <div class="relative">
                    <select name="category" required
                            class="mt-2 w-full appearance-none rounded-xl border border-line bg-surface pl-4 pr-10 py-2 text-xs font-medium text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent cursor-pointer">
                        @foreach ($validCategories as $category)
                            <option value="{{ $category }}" @selected(old('category', $editingProduct->category ?? '') === $category)>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-2 text-ink-muted">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>

            <!-- Input Deskripsi -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Deskripsi Lengkap</label>
                <textarea name="description" rows="3" required
                          class="mt-2 w-full rounded-xl border border-line bg-surface px-4 py-2 text-xs font-medium text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent resize-none">{{ old('description', $editingProduct->description ?? '') }}</textarea>
            </div>

            <!-- Input Harga & Stok (Inline Row) -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Harga Satuan (Rp)</label>
                    <input type="number" name="price" min="1" value="{{ old('price', $editingProduct->price ?? '') }}" required
                           class="mt-2 w-full rounded-xl border border-line bg-surface px-4 py-2 text-xs font-semibold text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Jumlah Kuantitas Stok</label>
                    <input type="number" name="stock" min="0" value="{{ old('stock', $editingProduct->stock ?? 0) }}" required
                           class="mt-2 w-full rounded-xl border border-line bg-surface px-4 py-2 text-xs font-semibold text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
                </div>
            </div>

            <!-- Tombol Aksi Form -->
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 rounded-xl bg-accent py-2.5 text-xs font-bold text-white shadow-sm shadow-accent/20 transition-all hover:opacity-90 active:scale-95">
                    {{ $editingProduct ? 'Simpan Perubahan' : 'Daftarkan Produk' }}
                </button>
                @if ($editingProduct)
                    <a href="{{ route('admin.products.index') }}"
                       class="rounded-xl border border-line bg-surface px-4 py-2.5 text-xs font-bold text-ink shadow-sm transition-all hover:bg-surface-light">
                        Batal
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
