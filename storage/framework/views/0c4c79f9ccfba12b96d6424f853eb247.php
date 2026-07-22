<?php $__env->startSection('title', 'Produk'); ?>

<?php $__env->startSection('content'); ?>
    <section class="mx-auto max-w-6xl px-6 py-16 text-center">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-accent">Skincare Collection</p>
        <h1 class="mt-3 font-serif text-3xl font-semibold text-ink sm:text-4xl">Produk Perawatan Premium</h1>
        <p class="mx-auto mt-4 max-w-xl text-sm text-ink-muted">
            Dipilih untuk melengkapi rutinitas perawatan harian Anda.
        </p>
    </section>

    <section class="mx-auto max-w-6xl px-6 pb-20">
        <?php if($productsByCategory->isEmpty()): ?>
            <div class="rounded-xl border border-line bg-surface p-10 text-center text-ink-muted">
                Belum ada produk tersedia saat ini.
            </div>
        <?php else: ?>
            <?php $__currentLoopData = $productsByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-14">
                    <h2 class="mb-5 font-serif text-xl font-semibold text-ink"><?php echo e($category); ?></h2>

                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div
                                class="flex flex-col justify-between rounded-xl border border-line bg-surface p-5 transition hover:border-accent">
                                <div>
                                    <?php if($product->imageUrl()): ?>
                                        <img src="<?php echo e($product->imageUrl()); ?>" alt="<?php echo e($product->name); ?>"
                                            class="mb-3 h-40 w-full rounded-lg object-cover">
                                    <?php else: ?>
                                        <div class="mb-3 h-40 w-full rounded-lg bg-gradient-to-br from-accent/20 to-surface-light"></div>
                                    <?php endif; ?>
                                    <span class="text-[11px] font-medium uppercase tracking-wide text-accent">
                                        <?php echo e($product->inStock() ? 'IN STOCK' : 'SOLD OUT'); ?>

                                    </span>
                                    <h3 class="mt-2 font-serif text-lg font-semibold text-ink">
                                        <a href="<?php echo e(route('products.show', $product)); ?>"
                                            class="hover:text-accent"><?php echo e($product->name); ?></a>
                                    </h3>
                                    <p class="mt-2 text-sm text-ink-muted">
                                        <?php echo e(\Illuminate\Support\Str::limit($product->description, 90)); ?>

                                    </p>
                                </div>

                                <div class="mt-5 flex items-center justify-between border-t border-line pt-4">
                                    <p class="font-semibold text-ink">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
                                    <div class="flex gap-2">
                                        <a href="<?php echo e(route('products.show', $product)); ?>"
                                            class="rounded-full border border-line px-3 py-1.5 text-xs font-medium text-ink hover:border-accent hover:text-accent">
                                            Detail
                                        </a>

                                        <?php if($product->inStock()): ?>
                                            <form method="POST" action="<?php echo e(route('cart.add')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                                <input type="hidden" name="name" value="<?php echo e($product->name); ?>">
                                                <input type="hidden" name="category" value="<?php echo e($product->category); ?>">
                                                <input type="hidden" name="image" value="<?php echo e($product->imageUrl()); ?>">
                                                <input type="hidden" name="price" value="<?php echo e($product->price); ?>">
                                                <input type="hidden" name="stock" value="<?php echo e($product->stock); ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit"
                                                    class="rounded-full bg-accent px-3 py-1.5 text-xs font-medium text-white hover:bg-accent-dark">
                                                    + Keranjang
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/products/index.blade.php ENDPATH**/ ?>