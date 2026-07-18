<?php $__env->startSection('title', 'Kelola Layanan'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $form = $editingService;
    $priceType = old('price_type', $form && $form->price_range ? 'range' : 'fixed');
?>

<!-- SUB-HEADER INFORMASIONAL -->
<div class="mb-6">
    <p class="text-xs text-ink-muted">Kelola jenis penawaran jasa, konfigurasi durasi kerja spesifik, serta kelola batas struktur penentuan harga dasar layanan.</p>
</div>

<!-- GRID SYSTEM LAYOUT UTAMA -->
<div class="grid gap-6 lg:grid-cols-[1fr_380px] items-start">

    
    <div class="overflow-hidden rounded-2xl border border-line bg-surface shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-surface-light/60 text-[10px] font-bold uppercase tracking-wider text-ink-muted/80 border-b border-line">
                    <tr>
                        <th class="px-5 py-4">Detail Layanan</th>
                        <th class="px-5 py-4">Klasifikasi Kategori</th>
                        <th class="px-5 py-4">Alokasi Durasi</th>
                        <th class="px-5 py-4">Tarif Harga</th>
                        <th class="px-5 py-4 text-right">Aksi Kontrol</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line/60">
                    <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-surface-light/30 transition-colors duration-150 <?php echo e($editingService?->id === $service->id ? 'bg-accent/5' : ''); ?>">

                            <!-- Thumbnail & Keterangan Text -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3.5">
                                    <?php if($service->imageUrl()): ?>
                                        <img src="<?php echo e($service->imageUrl()); ?>" alt="<?php echo e($service->name); ?>" class="h-11 w-11 shrink-0 rounded-xl border border-line object-cover shadow-sm">
                                    <?php else: ?>
                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-surface-light text-ink-muted/50 border border-line">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                        </div>
                                    <?php endif; ?>
                                    <div class="max-w-xs">
                                        <p class="font-medium text-ink text-xs tracking-tight"><?php echo e($service->name); ?></p>
                                        <p class="text-[10px] text-ink-muted/80 mt-0.5 line-clamp-1" title="<?php echo e($service->description); ?>"><?php echo e($service->description); ?></p>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori Label -->
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-xl bg-accent/10 px-2.5 py-1 text-[10px] font-bold tracking-wide text-accent uppercase">
                                    <?php echo e($service->category_name); ?>

                                </span>
                            </td>

                            <!-- Durasi -->
                            <td class="px-5 py-4 text-xs font-semibold text-ink-muted">
                                <span class="font-mono text-ink"><?php echo e($service->duration); ?></span> mnt
                            </td>

                            <!-- Tarif Terformat -->
                            <td class="px-5 py-4 text-xs font-bold text-ink">
                                <?php echo e($service->formattedPrice()); ?>

                            </td>

                            <!-- Kelompok Tombol Aksi -->
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="<?php echo e(route('admin.services.index', ['edit' => $service->id])); ?>"
                                       class="inline-flex items-center gap-1 rounded-xl border border-line bg-surface px-3 py-1.5 text-xs font-medium text-ink shadow-sm transition-all hover:border-accent hover:text-accent">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="<?php echo e(route('admin.services.destroy', $service)); ?>"
                                          onsubmit="return confirm('Hapus entri varian layanan <?php echo e($service->name); ?> dari database?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-xl border border-rose-200 bg-white px-3 py-1.5 text-xs font-medium text-rose-600 shadow-sm transition-all hover:bg-rose-50 hover:border-rose-300">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-xs text-ink-muted">Belum ada daftar layanan jasa operasional didaftarkan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="h-fit rounded-2xl border border-line bg-surface p-5 shadow-sm">
        <h2 class="text-xs font-bold uppercase tracking-wider text-ink border-b border-line pb-3.5">
            <?php echo e($editingService ? 'Modifikasi Dokumen Layanan' : 'Registrasi Layanan Baru'); ?>

        </h2>

        <?php if($errors->any()): ?>
            <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50/70 px-4 py-3 text-xs font-medium text-rose-700">
                <ul class="list-inside list-disc space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST"
              action="<?php echo e($editingService ? route('admin.services.update', $editingService) : route('admin.services.store')); ?>"
              enctype="multipart/form-data"
              class="mt-4 space-y-4">
            <?php echo csrf_field(); ?>
            <?php if($editingService): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <!-- Input Image Upload -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Cover / Gambar Layanan</label>
                <?php if($editingService?->image): ?>
                    <div class="relative inline-block mt-2">
                        <img src="<?php echo e($editingService->imageUrl()); ?>" alt="<?php echo e($editingService->name); ?>"
                             class="h-20 w-20 rounded-xl border border-line object-cover shadow-sm">
                    </div>
                <?php endif; ?>
                <input type="file" name="image" accept="image/*"
                       class="mt-2 w-full rounded-xl border border-line bg-surface px-3 py-1.5 text-xs text-ink shadow-sm file:mr-3 file:rounded-lg file:border-0 file:bg-accent/10 file:px-3 file:py-1 file:text-[11px] file:font-bold file:text-accent file:transition-all hover:file:bg-accent/20 cursor-pointer">
                <p class="mt-1 text-[10px] text-ink-muted/80">Format JPG, PNG, atau WebP (Maks. 2MB). <?php echo e($editingService ? 'Biarkan kosong jika tidak berniat mengganti gambar.' : ''); ?></p>
            </div>

            <!-- Input Nama Layanan -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Nama Layanan Jasa</label>
                <input type="text" name="name" value="<?php echo e(old('name', $form->name ?? '')); ?>" required
                       class="mt-2 w-full rounded-xl border border-line bg-surface px-4 py-2 text-xs font-medium text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
            </div>

            <!-- Input Pilihan Kategori -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Kategori Layanan</label>
                <div class="relative">
                    <select name="category" required
                            class="mt-2 w-full appearance-none rounded-xl border border-line bg-surface pl-4 pr-10 py-2 text-xs font-medium text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent cursor-pointer">
                        <?php $__currentLoopData = $validCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category); ?>" <?php if(old('category', $form->category ?? '') === $category): echo 'selected'; endif; ?>>
                                <?php echo e(\App\Models\Service::CATEGORY_LABELS[$category]); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-2 text-ink-muted">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>

            <!-- Input Keterangan Deskripsi -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Deskripsi Ringkas Kerja</label>
                <textarea name="description" rows="3" required
                          class="mt-2 w-full rounded-xl border border-line bg-surface px-4 py-2 text-xs font-medium text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent resize-none"><?php echo e(old('description', $form->description ?? '')); ?></textarea>
            </div>

            <!-- Input Durasi Operasional -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Estimasi Durasi Penyelesaian (Menit)</label>
                <input type="number" name="duration" min="1" value="<?php echo e(old('duration', $form->duration ?? '')); ?>" required
                       class="mt-2 w-full rounded-xl border border-line bg-surface px-4 py-2 text-xs font-semibold text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
            </div>

            <!-- Kelompok Skema Struktur Harga (Radio Button Premium) -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Tipe Penentuan Tarif</label>
                <div class="mt-2.5 flex items-center gap-6 text-xs font-medium text-ink">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="radio" name="price_type" value="fixed" <?php echo e($priceType === 'fixed' ? 'checked' : ''); ?>

                               onchange="document.getElementById('price-fixed').classList.remove('hidden'); document.getElementById('price-range').classList.add('hidden');"
                               class="h-4 w-4 border-line text-accent focus:ring-accent">
                        <span>Harga Tetap</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="radio" name="price_type" value="range" <?php echo e($priceType === 'range' ? 'checked' : ''); ?>

                               onchange="document.getElementById('price-range').classList.remove('hidden'); document.getElementById('price-fixed').classList.add('hidden');"
                               class="h-4 w-4 border-line text-accent focus:ring-accent">
                        <span>Mulai Dari (Range)</span>
                    </label>
                </div>
            </div>

            <!-- Input Harga Tetap Conditional -->
            <div id="price-fixed" class="<?php echo e($priceType === 'range' ? 'hidden' : ''); ?>">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Nominal Tarif (Rp)</label>
                <input type="number" name="price" min="0" value="<?php echo e(old('price', $form->price ?? '')); ?>"
                       class="mt-2 w-full rounded-xl border border-line bg-surface px-4 py-2 text-xs font-semibold text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
            </div>

            <!-- Input Rentang Harga Conditional -->
            <div id="price-range" class="<?php echo e($priceType === 'fixed' ? 'hidden' : ''); ?>">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-ink-muted/80">Batas Harga Terendah (Rp)</label>
                <input type="text" name="price_range" placeholder="Contoh: 350000" value="<?php echo e(old('price_range', $form->price_range ?? '')); ?>"
                       class="mt-2 w-full rounded-xl border border-line bg-surface px-4 py-2 text-xs font-semibold text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
            </div>

            <!-- Tombol Submit Operasional Form -->
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 rounded-xl bg-accent py-2.5 text-xs font-bold text-white shadow-sm shadow-accent/20 transition-all hover:opacity-90 active:scale-95">
                    <?php echo e($editingService ? 'Perbarui Data' : 'Daftarkan Jasa'); ?>

                </button>
                <?php if($editingService): ?>
                    <a href="<?php echo e(route('admin.services.index')); ?>"
                       class="rounded-xl border border-line bg-surface px-4 py-2.5 text-xs font-bold text-ink shadow-sm transition-all hover:bg-surface-light">
                        Batal
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/admin/services/index.blade.php ENDPATH**/ ?>