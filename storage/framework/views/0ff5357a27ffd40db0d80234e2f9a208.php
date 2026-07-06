<?php $__env->startSection('title', 'Riwayat Booking'); ?>

<?php $__env->startSection('content'); ?>
<section class="mx-auto max-w-5xl px-6 py-16">
    <h1 class="font-serif text-3xl font-semibold text-ink">Riwayat Booking</h1>
    <p class="mt-2 text-sm text-ink-muted">
        Selamat datang, <strong class="text-ink"><?php echo e(auth()->user()->name); ?></strong>. Kelola jadwal treatment Anda dari sini.
    </p>
    <a href="<?php echo e(route('booking.create')); ?>"
       class="mt-4 inline-block rounded-full bg-accent px-5 py-2.5 text-sm font-medium text-white hover:bg-accent-dark">
        + Reservasi Baru
    </a>

    <?php if($bookings->isEmpty()): ?>
        <div class="mt-10 rounded-xl border border-dashed border-line p-10 text-center text-ink-muted">
            Anda belum memiliki booking.
            <a href="<?php echo e(route('booking.create')); ?>" class="text-accent hover:underline">Buat booking sekarang</a>
        </div>
    <?php else: ?>
        <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-4">
            <div class="rounded-xl border border-line bg-surface p-4 text-center">
                <p class="text-xs text-ink-muted">Total Booking</p>
                <p class="mt-1 text-xl font-semibold text-ink"><?php echo e($statusCounts['all']); ?></p>
            </div>
            <div class="rounded-xl border border-line bg-surface p-4 text-center">
                <p class="text-xs text-ink-muted">Menunggu</p>
                <p class="mt-1 text-xl font-semibold text-ink"><?php echo e($statusCounts['pending']); ?></p>
            </div>
            <div class="rounded-xl border border-line bg-surface p-4 text-center">
                <p class="text-xs text-ink-muted">Dikonfirmasi</p>
                <p class="mt-1 text-xl font-semibold text-ink"><?php echo e($statusCounts['confirmed']); ?></p>
            </div>
            <div class="rounded-xl border border-line bg-surface p-4 text-center">
                <p class="text-xs text-ink-muted">Selesai</p>
                <p class="mt-1 text-xl font-semibold text-ink"><?php echo e($statusCounts['completed']); ?></p>
            </div>
        </div>

        <div class="mt-8 space-y-4">
            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $statusColor = match ($booking->status) {
                        'confirmed' => 'bg-blue-50 text-blue-700',
                        'completed' => 'bg-emerald-50 text-emerald-700',
                        'cancelled' => 'bg-red-50 text-red-700',
                        default => 'bg-amber-50 text-amber-700',
                    };
                ?>
                <article class="rounded-xl border border-line bg-surface p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-ink-muted">Booking #<?php echo e($booking->id); ?></p>
                        <span class="rounded-full px-3 py-1 text-xs font-medium <?php echo e($statusColor); ?>"><?php echo e($booking->statusLabel()); ?></span>
                    </div>
                    <h3 class="mt-2 font-serif text-lg font-semibold text-ink"><?php echo e($booking->service_name); ?></h3>

                    <div class="mt-3 grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-ink-muted">Tanggal</p>
                            <p class="text-ink"><?php echo e($booking->booking_date->translatedFormat('d M Y')); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-ink-muted">Jam</p>
                            <p class="text-ink"><?php echo e($booking->booking_time->format('H:i')); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-ink-muted">Dibuat</p>
                            <p class="text-ink"><?php echo e($booking->created_at->translatedFormat('d M Y, H:i')); ?></p>
                        </div>
                    </div>

                    <div class="mt-4 flex gap-3">
                        <a href="<?php echo e(route('booking.create', ['service' => $booking->service_name])); ?>"
                           class="rounded-full bg-accent px-4 py-2 text-xs font-medium text-white hover:bg-accent-dark">
                            Pesan Lagi
                        </a>
                        <a href="<?php echo e($booking->whatsappLink()); ?>" target="_blank" rel="noopener"
                           class="rounded-full border border-line px-4 py-2 text-xs font-medium text-ink hover:border-accent hover:text-accent">
                            Hubungi
                        </a>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/booking/my-bookings.blade.php ENDPATH**/ ?>