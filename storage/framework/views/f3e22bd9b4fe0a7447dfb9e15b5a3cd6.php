<?php $__env->startSection('title', 'Booking List'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 grid grid-cols-3 gap-4">
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Menunggu</p>
        <p class="mt-1 text-xl font-semibold text-ink"><?php echo e($totalPending); ?></p>
    </div>
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Selesai</p>
        <p class="mt-1 text-xl font-semibold text-ink"><?php echo e($totalCompleted); ?></p>
    </div>
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Dibatalkan</p>
        <p class="mt-1 text-xl font-semibold text-ink"><?php echo e($totalCancelled); ?></p>
    </div>
</div>

<div class="mb-4 flex flex-wrap gap-2">
    <a href="<?php echo e(route('admin.bookings.index')); ?>"
       class="rounded-full px-3 py-1.5 text-xs font-medium <?php echo e($filterStatus === '' ? 'bg-accent text-white' : 'border border-line text-ink hover:border-accent'); ?>">
        Semua
    </a>
    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('admin.bookings.index', ['status' => $status])); ?>"
           class="rounded-full px-3 py-1.5 text-xs font-medium <?php echo e($filterStatus === $status ? 'bg-accent text-white' : 'border border-line text-ink hover:border-accent'); ?>">
            <?php echo e(\App\Models\Booking::STATUS_LABELS[$status]); ?>

        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="overflow-hidden rounded-xl border border-line bg-surface">
    <table class="w-full text-left text-sm">
        <thead class="bg-surface-light text-xs uppercase tracking-wide text-ink-muted">
            <tr>
                <th class="px-4 py-3">Pelanggan</th>
                <th class="px-4 py-3">Layanan</th>
                <th class="px-4 py-3">Jadwal</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-line">
            <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-4 py-3">
                        <p class="font-medium text-ink"><?php echo e($booking->customer_name); ?></p>
                        <p class="text-xs text-ink-muted"><?php echo e($booking->whatsapp); ?></p>
                    </td>
                    <td class="px-4 py-3 text-ink-muted"><?php echo e($booking->service_name); ?></td>
                    <td class="px-4 py-3 text-ink-muted">
                        <?php echo e($booking->booking_date->format('d M Y')); ?><br>
                        <span class="text-xs"><?php echo e($booking->booking_time->format('H:i')); ?></span>
                    </td>
                    <td class="px-4 py-3">
                        <form method="POST" action="<?php echo e(route('admin.bookings.update', $booking)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <select name="status" onchange="this.form.submit()"
                                    class="rounded-lg border border-line bg-white px-2 py-1.5 text-xs">
                                <?php $__currentLoopData = \App\Models\Booking::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>" <?php if($booking->status === $status): echo 'selected'; endif; ?>>
                                        <?php echo e(\App\Models\Booking::STATUS_LABELS[$status]); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="<?php echo e(route('admin.bookings.destroy', $booking)); ?>"
                              onsubmit="return confirm('Hapus booking #<?php echo e($booking->id); ?>?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="rounded-md border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-ink-muted">Belum ada booking.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-4">
    <?php echo e($bookings->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/admin/bookings/index.blade.php ENDPATH**/ ?>