<?php $__env->startSection('title', 'Product Stock Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid gap-8 lg:grid-cols-[1fr_360px]">
    
    <div class="overflow-hidden rounded-xl border border-line bg-surface">
        <table class="w-full text-left text-sm">
            <thead class="bg-surface-light text-xs uppercase tracking-wide text-ink-muted">
                <tr>
                    <th class="px-4 py-3">Produk</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3 text-center">Stok</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e($editingProduct?->id === $product->id ? 'bg-accent/5' : ''); ?> <?php echo e(! $product->is_active ? 'opacity-50' : ''); ?>">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <?php if($product->imageUrl()): ?>
                                    <img src="<?php echo e($product->imageUrl()); ?>" alt="<?php echo e($product->name); ?>" class="h-10 w-10 shrink-0 rounded-lg border border-line object-cover">
                                <?php else: ?>
                                    <div class="h-10 w-10 shrink-0 rounded-lg bg-surface-light"></div>
                                <?php endif; ?>
                                <div>
                                    <p class="font-medium text-ink"><?php echo e($product->name); ?></p>
                                    <p class="text-xs text-ink-muted line-clamp-1"><?php echo e(\Illuminate\Support\Str::limit($product->description, 64)); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="rounded bg-accent/10 px-2 py-1 text-xs font-medium text-accent"><?php echo e($product->category); ?></span>
                        </td>
                        <td class="px-4 py-3 text-ink-muted"><?php echo e($product->formattedPrice()); ?></td>
                        <td class="px-4 py-3 text-center">
                            <span class="rounded px-2 py-1 text-xs <?php echo e($product->stock > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'); ?>">
                                <?php echo e($product->stock > 0 ? $product->stock : 'Habis'); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <form method="POST" action="<?php echo e(route('admin.products.toggle', $product)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit"
                                        class="rounded-md px-3 py-1.5 text-xs font-medium text-white <?php echo e($product->is_active ? 'bg-blue-500 hover:bg-blue-600' : 'bg-gray-400 hover:bg-gray-500'); ?>">
                                    <?php echo e($product->is_active ? 'Aktif' : 'Nonaktif'); ?>

                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="<?php echo e(route('admin.products.index', ['edit' => $product->id])); ?>"
                                   class="rounded-md border border-line px-3 py-1.5 text-xs font-medium text-ink hover:border-accent hover:text-accent">
                                    Edit
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.products.destroy', $product)); ?>"
                                      onsubmit="return confirm('Hapus produk <?php echo e($product->name); ?>?');">
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
                        <td colspan="6" class="px-4 py-10 text-center text-ink-muted">Belum ada produk.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="h-fit rounded-xl border border-line bg-surface p-5">
        <h2 class="font-serif text-lg font-semibold text-ink">
            <?php echo e($editingProduct ? 'Edit Produk #'.$editingProduct->id : 'Tambah Produk Baru'); ?>

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
              action="<?php echo e($editingProduct ? route('admin.products.update', $editingProduct) : route('admin.products.store')); ?>"
              enctype="multipart/form-data"
              class="mt-4 space-y-4">
            <?php echo csrf_field(); ?>
            <?php if($editingProduct): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Gambar Produk</label>
                <?php if($editingProduct?->image): ?>
                    <img src="<?php echo e($editingProduct->imageUrl()); ?>" alt="<?php echo e($editingProduct->name); ?>"
                         class="mt-2 h-24 w-24 rounded-lg border border-line object-cover">
                <?php endif; ?>
                <input type="file" name="image" accept="image/*"
                       class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-accent/10 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-accent">
                <p class="mt-1 text-xs text-ink-muted">JPG/PNG/WebP, maks 2MB. <?php echo e($editingProduct ? 'Kosongkan kalau tidak ingin ganti gambar.' : ''); ?></p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Nama Produk</label>
                <input type="text" name="name" value="<?php echo e(old('name', $editingProduct->name ?? '')); ?>" required
                       class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Kategori</label>
                <select name="category" required
                        class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                    <?php $__currentLoopData = $validCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category); ?>" <?php if(old('category', $editingProduct->category ?? '') === $category): echo 'selected'; endif; ?>>
                            <?php echo e($category); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Deskripsi</label>
                <textarea name="description" rows="3" required
                          class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20"><?php echo e(old('description', $editingProduct->description ?? '')); ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Harga (Rp)</label>
                    <input type="number" name="price" min="1" value="<?php echo e(old('price', $editingProduct->price ?? '')); ?>" required
                           class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Stok</label>
                    <input type="number" name="stock" min="0" value="<?php echo e(old('stock', $editingProduct->stock ?? 0)); ?>"
                           class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 rounded-lg bg-accent py-2.5 text-sm font-medium text-white hover:bg-accent-dark">
                    <?php echo e($editingProduct ? 'Simpan Perubahan' : '+ Tambah Produk'); ?>

                </button>
                <?php if($editingProduct): ?>
                    <a href="<?php echo e(route('admin.products.index')); ?>"
                       class="rounded-lg border border-line px-4 py-2.5 text-sm font-medium text-ink hover:border-accent">
                        Batal
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/admin/products/index.blade.php ENDPATH**/ ?>