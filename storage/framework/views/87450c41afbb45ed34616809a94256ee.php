<header class="border-b border-line bg-surface/80 backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-6 py-4">
        <a href="<?php echo e(route('home')); ?>" class="group">
            <span class="font-serif text-2xl font-semibold text-ink group-hover:text-accent transition-colors">
                <?php echo e($siteConfig['name']); ?>

            </span>
        </a>

        <nav class="flex items-center gap-6 text-sm font-medium">
            <a href="<?php echo e(route('home')); ?>"
                class="<?php echo e(request()->routeIs('home') ? 'text-accent' : 'text-ink hover:text-accent'); ?> transition-colors">
                Beranda
            </a>
            <a href="<?php echo e(route('services.index')); ?>"
                class="<?php echo e(request()->routeIs('services.index') ? 'text-accent' : 'text-ink hover:text-accent'); ?> transition-colors">
                Layanan
            </a>
            <a href="<?php echo e(route('products.index')); ?>"
                class="<?php echo e(request()->routeIs('products.*') ? 'text-accent' : 'text-ink hover:text-accent'); ?> transition-colors">
                Produk
            </a>
            <a href="<?php echo e(route('booking.create')); ?>"
                class="<?php echo e(request()->routeIs('booking.*') ? 'text-accent' : 'text-ink hover:text-accent'); ?> transition-colors">
                Booking
            </a>

            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('cart.index')); ?>"
                    class="<?php echo e(request()->routeIs('cart.*') ? 'text-accent' : 'text-ink hover:text-accent'); ?> relative transition-colors">
                    Cart
                    <?php if(\App\Support\Cart::count() > 0): ?>
                        <span
                            class="absolute -right-3 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-accent text-[10px] font-semibold text-white">
                            <?php echo e(\App\Support\Cart::count()); ?>

                        </span>
                    <?php endif; ?>
                </a>
                <?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.services.index')); ?>"
                        class="<?php echo e(request()->routeIs('admin.*') ? 'text-accent' : 'text-ink hover:text-accent'); ?> transition-colors">
                        Kelola Layanan
                    </a>
                <?php endif; ?>

                <div class="flex items-center gap-3 border-l border-line pl-6">
                    <?php if (! (auth()->user()->isAdmin())): ?>
                        <a href="<?php echo e(route('bookings.mine')); ?>"
                            class="<?php echo e(request()->routeIs('bookings.mine') ? 'text-accent' : 'text-ink-muted hover:text-accent'); ?> text-xs">
                            Booking Saya
                        </a>
                        <a href="<?php echo e(route('account.edit')); ?>"
                            class="<?php echo e(request()->routeIs('account.*') ? 'text-accent' : 'text-ink-muted hover:text-accent'); ?> text-xs">
                            Akun Saya
                        </a>
                    <?php endif; ?>
                    <span class="text-ink-muted">Hai, <?php echo e(explode(' ', auth()->user()->name)[0]); ?></span>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                            class="rounded-full bg-accent px-4 py-2 text-white transition hover:bg-accent-dark">
                            Logout
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>"
                    class="rounded-full bg-accent px-4 py-2 text-white transition hover:bg-accent-dark">
                    Login
                </a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/partials/navbar.blade.php ENDPATH**/ ?>