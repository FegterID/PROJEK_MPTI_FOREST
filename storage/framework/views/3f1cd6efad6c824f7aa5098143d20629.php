<?php $__env->startSection('title', 'Layanan'); ?>

<?php $__env->startSection('content'); ?>
<section class="mx-auto max-w-6xl px-6 py-16 text-center">
    <p class="text-xs font-medium uppercase tracking-[0.3em] text-accent">Layanan Kami</p>
    <h1 class="mt-3 font-serif text-3xl font-semibold text-ink sm:text-4xl">Pilih Layanan Favorit Anda</h1>
    <p class="mx-auto mt-4 max-w-xl text-sm text-ink-muted">
        Katalog layanan kami disusun per kategori supaya lebih mudah dibandingkan sebelum reservasi.
    </p>

    <div class="mt-6 flex flex-wrap justify-center gap-2 text-xs font-medium text-ink-muted">
        <span class="rounded-full border border-line px-3 py-1">Konsultasi Gratis</span>
        <span class="rounded-full border border-line px-3 py-1">Therapist Bersertifikat</span>
        <span class="rounded-full border border-line px-3 py-1">Produk Premium</span>
        <span class="rounded-full border border-line px-3 py-1">Bisa Langsung Reservasi</span>
    </div>
</section>

<section class="mx-auto max-w-6xl px-6 pb-20">
    <?php if($servicesByCategory->isEmpty()): ?>
        <div class="rounded-xl border border-line bg-surface p-10 text-center text-ink-muted">
            Belum ada layanan tersedia saat ini.
        </div>
    <?php else: ?>
        <?php $__currentLoopData = $categoryMeta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryKey => $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($servicesByCategory->get($categoryKey, collect())->isEmpty()) continue; ?>

            <div class="mb-14">
                <h2 class="mb-5 font-serif text-xl font-semibold text-ink"><?php echo e($meta['title']); ?></h2>

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $servicesByCategory[$categoryKey]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex flex-col justify-between rounded-xl border border-line bg-surface p-5 transition hover:border-accent">
                            <div>
                                <?php if($service->imageUrl()): ?>
                                    <img src="<?php echo e($service->imageUrl()); ?>" alt="<?php echo e($service->name); ?>"
                                         class="mb-3 h-40 w-full rounded-lg object-cover">
                                <?php endif; ?>
                                <span class="text-[11px] font-medium uppercase tracking-wide text-accent"><?php echo e($meta['label']); ?></span>
                                <h3 class="mt-2 font-serif text-lg font-semibold text-ink"><?php echo e($service->name); ?></h3>
                                <p class="mt-2 text-sm text-ink-muted"><?php echo e($service->description); ?></p>
                            </div>

                            <div class="mt-5 flex items-center justify-between border-t border-line pt-4">
                                <div>
                                    <p class="font-semibold text-ink"><?php echo e($service->formattedPrice()); ?></p>
                                    <p class="text-xs text-ink-muted"><?php echo e($service->duration); ?> menit</p>
                                </div>
                                <a href="<?php echo e(route('booking.create', ['service' => $service->name ?? $service['name'] ?? ''])); ?>"
                                class="inline-block rounded-full bg-accent px-4 py-2 text-xs font-medium text-white shadow-sm transition-all duration-200 hover:bg-accent-dark hover:shadow focus:outline-none">
                                    Booking Sekarang
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/services/index.blade.php ENDPATH**/ ?>