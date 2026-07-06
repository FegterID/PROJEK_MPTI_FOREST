<?php $__env->startSection('title', 'Cart'); ?>

<?php $__env->startSection('content'); ?>
<section class="mx-auto max-w-6xl px-6 py-12">
    <p class="text-xs text-ink-muted">DESKTOP - CHECKOUT</p>
    <h1 class="mt-2 font-serif text-3xl font-semibold text-ink">Complete Your Order</h1>
    <p class="mt-1 text-sm text-ink-muted">Review your selection and finalize your purchase.</p>

    <?php if($errors->any()): ?>
        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_340px]">
        <div class="space-y-8">
            
            <section class="rounded-xl border border-line bg-surface p-6">
                <h2 class="font-serif text-lg font-semibold text-ink">Your Selection</h2>

                <?php if(count($cartItems) === 0): ?>
                    <div class="mt-6 rounded-lg border border-dashed border-line p-8 text-center text-ink-muted">
                        <p>Keranjang kamu masih kosong.</p>
                        <a href="<?php echo e(route('products.index')); ?>" class="mt-2 inline-block font-medium text-accent hover:underline">Lihat Produk</a>
                    </div>
                <?php else: ?>
                    <div class="mt-4 divide-y divide-line">
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemKey => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex flex-wrap items-center justify-between gap-4 py-4">
                                <div class="flex items-center gap-4">
                                    <?php if(! empty($item['image'])): ?>
                                        <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['name']); ?>" class="h-14 w-14 shrink-0 rounded-lg object-cover">
                                    <?php else: ?>
                                        <div class="h-14 w-14 shrink-0 rounded-lg bg-gradient-to-br from-accent/20 to-surface-light"></div>
                                    <?php endif; ?>
                                    <div>
                                        <p class="font-medium text-ink"><?php echo e($item['name']); ?></p>
                                        <p class="text-xs text-ink-muted"><?php echo e($item['category']); ?></p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <form method="POST" action="<?php echo e(route('cart.update', $itemKey)); ?>" class="flex items-center gap-2">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <label class="text-xs text-ink-muted">Qty</label>
                                        <input type="number" name="quantity" value="<?php echo e($item['quantity']); ?>" min="1" max="<?php echo e($item['stock']); ?>"
                                               class="w-16 rounded-lg border border-line bg-white px-2 py-1.5 text-sm">
                                        <button type="submit" class="rounded-lg border border-line px-3 py-1.5 text-xs font-medium hover:border-accent hover:text-accent">
                                            Update
                                        </button>
                                    </form>

                                    <p class="w-28 text-right text-sm font-semibold text-ink">
                                        Rp <?php echo e(number_format($item['price'] * $item['quantity'], 0, ',', '.')); ?>

                                    </p>

                                    <form method="POST" action="<?php echo e(route('cart.remove', $itemKey)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </section>

            
            <section class="rounded-xl border border-line bg-surface p-6">
                <h2 class="font-serif text-lg font-semibold text-ink">Customer Information</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-ink-muted">Full Name</p>
                        <p class="mt-1 text-sm text-ink"><?php echo e($customerName); ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-ink-muted">Phone Number</p>
                        <p class="mt-1 text-sm text-ink"><?php echo e($customerPhone); ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-ink-muted">Email</p>
                        <p class="mt-1 text-sm text-ink"><?php echo e($customerEmail); ?></p>
                    </div>
                </div>
                <?php if(auth()->guard()->guest()): ?>
                    <p class="mt-3 text-xs text-ink-muted">
                        <a href="<?php echo e(route('login')); ?>" class="text-accent hover:underline">Login</a> untuk memakai data akun kamu saat checkout.
                    </p>
                <?php endif; ?>
            </section>

            <section class="rounded-xl border border-line bg-surface p-6">
                <h2 class="font-serif text-lg font-semibold text-ink">Shipping Address</h2>
                <p class="mt-3 whitespace-pre-line text-sm text-ink-muted"><?php echo e($customerAddress); ?></p>
            </section>
        </div>

        
        <aside class="h-fit rounded-xl border border-line bg-surface p-6">
            <h2 class="font-serif text-lg font-semibold text-ink">Summary</h2>
            <div class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between text-ink-muted">
                    <span>Subtotal</span>
                    <strong class="text-ink">Rp <?php echo e(number_format($subtotal, 0, ',', '.')); ?></strong>
                </div>
                <div class="flex justify-between text-ink-muted">
                    <span>Shipping</span>
                    <strong class="text-ink">Free</strong>
                </div>
                <div class="flex justify-between border-t border-line pt-2 text-base font-semibold text-ink">
                    <span>Total</span>
                    <span>Rp <?php echo e(number_format($subtotal, 0, ',', '.')); ?></span>
                </div>
            </div>

            <form method="POST" action="<?php echo e(route('cart.checkout')); ?>" class="mt-6">
                <?php echo csrf_field(); ?>
                <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Payment Method</label>
                <div class="mt-2 space-y-2 text-sm">
                    <label class="flex items-center gap-2 rounded-lg border border-line px-3 py-2">
                        <input type="radio" name="payment_method" value="bank_transfer" checked>
                        Bank Transfer
                    </label>
                    <label class="flex items-center gap-2 rounded-lg border border-line px-3 py-2">
                        <input type="radio" name="payment_method" value="cod">
                        Cash on Delivery
                    </label>
                    <label class="flex items-center gap-2 rounded-lg border border-line px-3 py-2">
                        <input type="radio" name="payment_method" value="ewallet">
                        E-Wallet
                    </label>
                </div>

                <button type="submit" <?php if(count($cartItems) === 0): ?> disabled <?php endif; ?>
                        class="mt-6 w-full rounded-full bg-accent py-3 text-sm font-medium text-white transition hover:bg-accent-dark disabled:cursor-not-allowed disabled:bg-ink-muted/40">
                    Place Order
                </button>
            </form>

            <p class="mt-4 text-center text-xs text-ink-muted">Encrypted, secure transaction</p>
        </aside>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/cart/index.blade.php ENDPATH**/ ?>