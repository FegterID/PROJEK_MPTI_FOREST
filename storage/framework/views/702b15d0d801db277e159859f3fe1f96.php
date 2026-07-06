<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin &mdash; <?php echo e($siteConfig['name']); ?> <?php if (! empty(trim($__env->yieldContent('title')))): ?>&mdash; <?php echo $__env->yieldContent('title'); ?><?php endif; ?></title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|cormorant-garamond:600,700" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-screen bg-bg text-ink antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 shrink-0 border-r border-line bg-surface">
            <div class="border-b border-line px-6 py-5">
                <p class="font-serif text-lg font-semibold text-ink"><?php echo e($siteConfig['name']); ?></p>
                <p class="text-xs uppercase tracking-wide text-ink-muted">Admin Panel</p>
            </div>

            <?php
                $adminNav = [
                    ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'available' => true],
                    ['label' => 'Booking', 'route' => 'admin.bookings.index', 'available' => true],
                    ['label' => 'Pesanan', 'route' => 'admin.orders.index', 'available' => true],
                    ['label' => 'Produk', 'route' => 'admin.products.index', 'available' => true],
                    ['label' => 'Layanan', 'route' => 'admin.services.index', 'available' => true],
                ];
            ?>

            <nav class="space-y-1 px-3 py-4 text-sm">
                <?php $__currentLoopData = $adminNav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($item['available']): ?>
                        <a href="<?php echo e(route($item['route'])); ?>"
                           class="block rounded-lg px-3 py-2 font-medium transition <?php echo e(request()->routeIs($item['route']) ? 'bg-accent text-white' : 'text-ink hover:bg-surface-light'); ?>">
                            <?php echo e($item['label']); ?>

                        </a>
                    <?php else: ?>
                        <span class="flex items-center justify-between rounded-lg px-3 py-2 text-ink-muted/60">
                            <?php echo e($item['label']); ?>

                            <span class="rounded-full border border-line px-2 py-0.5 text-[10px] uppercase tracking-wide">Segera</span>
                        </span>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>

            <div class="mt-auto border-t border-line px-3 py-4">
                <a href="<?php echo e(route('home')); ?>" class="block rounded-lg px-3 py-2 text-sm text-ink-muted hover:bg-surface-light">
                    &larr; Kembali ke situs
                </a>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-1">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm text-ink-muted hover:bg-surface-light">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1">
            <header class="border-b border-line bg-surface px-8 py-5">
                <h1 class="font-serif text-xl font-semibold text-ink"><?php echo $__env->yieldContent('title'); ?></h1>
            </header>

            <main class="p-8">
                <?php if(session('success')): ?>
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
</body>
</html>
<?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/layouts/admin.blade.php ENDPATH**/ ?>