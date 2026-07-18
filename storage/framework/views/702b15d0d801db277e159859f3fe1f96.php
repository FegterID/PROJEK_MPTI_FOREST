<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin &mdash; <?php echo e($siteConfig['name']); ?> <?php if (! empty(trim($__env->yieldContent('title')))): ?>&mdash; <?php echo $__env->yieldContent('title'); ?><?php endif; ?></title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|cormorant-garamond:600,700"
        rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="h-full bg-bg text-ink antialiased selection:bg-accent/10 selection:text-accent">
    <div class="flex min-h-screen">

        <!-- SIDEBAR: ELEGAN & STRUKTUR MINIMALIS -->
        <aside class="fixed inset-y-0 left-0 z-20 w-64 border-r border-line bg-surface px-4 py-6 flex flex-col justify-between hidden lg:flex">
            <div>
                <!-- Branding Header -->
                <div class="px-3 mb-8">
                    <p class="font-serif text-xl font-bold tracking-tight text-ink leading-tight"><?php echo e($siteConfig['name']); ?></p>
                    <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-ink-muted/70">Console Management</p>
                </div>

                <?php
                    $adminNav = [
                        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" /></svg>', 'available' => true],
                        ['label' => 'Booking Antrean', 'route' => 'admin.bookings.index', 'icon' => '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>', 'available' => true],
                        ['label' => 'Pesanan Produk', 'route' => 'admin.orders.index', 'icon' => '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>', 'available' => true],
                        ['label' => 'Katalog Produk', 'route' => 'admin.products.index', 'icon' => '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>', 'available' => true],
                        ['label' => 'Layanan Toko', 'route' => 'admin.services.index', 'icon' => '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>', 'available' => true],
                    ];
                ?>

                <!-- Nav List -->
                <nav class="space-y-1 text-xs">
                    <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-ink-muted/50 mb-3">Menu Navigasi</p>
                    <?php $__currentLoopData = $adminNav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $isActive = request()->routeIs($item['route']); ?>
                        <?php if($item['available']): ?>
                            <a href="<?php echo e(route($item['route'])); ?>"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 font-medium tracking-wide transition-all duration-200
                                <?php echo e($isActive ? 'bg-accent text-white shadow-sm shadow-accent/20 font-semibold' : 'text-ink-muted hover:text-ink hover:bg-surface-light/70'); ?>">
                                <span class="<?php echo e($isActive ? 'text-white' : 'text-ink-muted/70 group-hover:text-ink'); ?>">
                                    <?php echo $item['icon']; ?>

                                </span>
                                <?php echo e($item['label']); ?>

                            </a>
                        <?php else: ?>
                            <span class="flex items-center justify-between rounded-xl px-3 py-2.5 text-ink-muted/40 font-medium">
                                <span class="flex items-center gap-3">
                                    <?php echo $item['icon']; ?>

                                    <?php echo e($item['label']); ?>

                                </span>
                                <span class="rounded-full bg-surface-light border border-line px-2 py-0.5 text-[9px] uppercase tracking-wide text-ink-muted/60">Segera</span>
                            </span>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </nav>
            </div>

            <!-- Footer Sidebar: Account Actions -->
            <div class="border-t border-line/60 pt-4">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="group flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-xs font-medium text-ink-muted/80 hover:text-rose-600 hover:bg-rose-50/50 transition-all duration-200">
                        <svg class="h-4 w-4 text-ink-muted/60 group-hover:text-rose-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Sign Out Console
                    </button>
                </form>
            </div>
        </aside>

        <!-- CONTAINER UTAMA KANAN -->
        <div class="flex-1 lg:pl-64 flex flex-col min-w-0">

            <!-- NAVBAR ATAS STICKY (GLASSMORPHISM) -->
            <header class="sticky top-0 z-10 flex h-16 items-center justify-between border-b border-line bg-surface/80 px-6 backdrop-blur-md sm:px-8">
                <div>
                    <h1 class="font-serif text-lg font-bold tracking-tight text-ink"><?php echo $__env->yieldContent('title', 'Menu Utama'); ?></h1>
                </div>


            </header>

            <!-- AREA KONTEN UTAMA -->
            <main class="flex-1 p-6 sm:p-8 max-w-[1600px] w-full mx-auto">
                <?php if(session('success')): ?>
                    <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-500/10 bg-emerald-50/50 px-4 py-3 text-xs font-medium text-emerald-800 backdrop-blur-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
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