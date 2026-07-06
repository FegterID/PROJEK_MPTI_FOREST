<?php $__env->startSection('title', 'Kelola Layanan'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $form = $editingService;
    $priceType = old('price_type', $form && $form->price_range ? 'range' : 'fixed');
?>

<div class="grid gap-8 lg:grid-cols-[1fr_360px]">
    
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
                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e($editingService?->id === $service->id ? 'bg-accent/5' : ''); ?>">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <?php if($service->imageUrl()): ?>
                                    <img src="<?php echo e($service->imageUrl()); ?>" alt="<?php echo e($service->name); ?>" class="h-10 w-10 shrink-0 rounded-lg border border-line object-cover">
                                <?php else: ?>
                                    <div class="h-10 w-10 shrink-0 rounded-lg bg-surface-light"></div>
                                <?php endif; ?>
                                <div>
                                    <p class="font-medium text-ink"><?php echo e($service->name); ?></p>
                                    <p class="text-xs text-ink-muted line-clamp-1"><?php echo e($service->description); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-ink-muted"><?php echo e($service->category_name); ?></td>
                        <td class="px-4 py-3 text-ink-muted"><?php echo e($service->duration); ?> mnt</td>
                        <td class="px-4 py-3 text-ink-muted"><?php echo e($service->formattedPrice()); ?></td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="<?php echo e(route('admin.services.index', ['edit' => $service->id])); ?>"
                                   class="rounded-md border border-line px-3 py-1.5 text-xs font-medium text-ink hover:border-accent hover:text-accent">
                                    Edit
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.services.destroy', $service)); ?>"
                                      onsubmit="return confirm('Hapus layanan <?php echo e($service->name); ?>?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="rounded-md border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-ink-muted">Belum ada layanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="h-fit rounded-xl border border-line bg-surface p-5">
        <h2 class="font-serif text-lg font-semibold text-ink">
            <?php echo e($editingService ? 'Edit Layanan' : 'Tambah Layanan'); ?>

        </h2>

        <?php if($errors->any()): ?>
            <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
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

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Gambar Layanan</label>
                <?php if($editingService?->image): ?>
                    <img src="<?php echo e($editingService->imageUrl()); ?>" alt="<?php echo e($editingService->name); ?>"
                         class="mt-2 h-24 w-24 rounded-lg border border-line object-cover">
                <?php endif; ?>
                <input type="file" name="image" accept="image/*"
                       class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-accent/10 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-accent">
                <p class="mt-1 text-xs text-ink-muted">JPG/PNG/WebP, maks 2MB. <?php echo e($editingService ? 'Kosongkan kalau tidak ingin ganti gambar.' : ''); ?></p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Nama Layanan</label>
                <input type="text" name="name" value="<?php echo e(old('name', $form->name ?? '')); ?>" required
                       class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Kategori</label>
                <select name="category" required
                        class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                    <?php $__currentLoopData = $validCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category); ?>" <?php if(old('category', $form->category ?? '') === $category): echo 'selected'; endif; ?>>
                            <?php echo e(\App\Models\Service::CATEGORY_LABELS[$category]); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Deskripsi</label>
                <textarea name="description" rows="3" required
                          class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20"><?php echo e(old('description', $form->description ?? '')); ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Durasi (menit)</label>
                <input type="number" name="duration" min="1" value="<?php echo e(old('duration', $form->duration ?? '')); ?>" required
                       class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Tipe Harga</label>
                <div class="mt-2 flex gap-4 text-sm">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="price_type" value="fixed" <?php echo e($priceType === 'fixed' ? 'checked' : ''); ?>

                               onchange="document.getElementById('price-fixed').classList.remove('hidden'); document.getElementById('price-range').classList.add('hidden');">
                        Tetap
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="price_type" value="range" <?php echo e($priceType === 'range' ? 'checked' : ''); ?>

                               onchange="document.getElementById('price-range').classList.remove('hidden'); document.getElementById('price-fixed').classList.add('hidden');">
                        Mulai dari
                    </label>
                </div>
            </div>

            <div id="price-fixed" class="<?php echo e($priceType === 'range' ? 'hidden' : ''); ?>">
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Harga (Rp)</label>
                <input type="number" name="price" min="0" value="<?php echo e(old('price', $form->price ?? '')); ?>"
                       class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
            </div>

            <div id="price-range" class="<?php echo e($priceType === 'fixed' ? 'hidden' : ''); ?>">
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Rentang Harga</label>
                <input type="text" name="price_range" placeholder="mis. 350000" value="<?php echo e(old('price_range', $form->price_range ?? '')); ?>"
                       class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 rounded-lg bg-accent py-2.5 text-sm font-medium text-white hover:bg-accent-dark">
                    <?php echo e($editingService ? 'Update' : 'Simpan'); ?>

                </button>
                <?php if($editingService): ?>
                    <a href="<?php echo e(route('admin.services.index')); ?>"
                       class="rounded-lg border border-line px-4 py-2.5 text-sm font-medium text-ink hover:border-accent">
                        Batal
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/admin/services/index.blade.php ENDPATH**/ ?>