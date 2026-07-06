<?php $__env->startSection('title', 'Orders'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 grid grid-cols-3 gap-4">
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Total Pesanan</p>
        <p class="mt-1 text-xl font-semibold text-ink"><?php echo e($totalOrders); ?></p>
    </div>
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Sudah Dibayar</p>
        <p class="mt-1 text-xl font-semibold text-ink"><?php echo e($paidOrders); ?></p>
    </div>
    <div class="rounded-xl border border-line bg-surface p-4 text-center">
        <p class="text-xs text-ink-muted">Menunggu</p>
        <p class="mt-1 text-xl font-semibold text-ink"><?php echo e($pendingOrders); ?></p>
    </div>
</div>

<form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="mb-4 flex flex-wrap gap-3">
    <input type="text" name="q" value="<?php echo e($search); ?>" placeholder="Cari nomor order / nama pelanggan..."
           class="flex-1 rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
    <select name="status" onchange="this.form.submit()"
            class="rounded-lg border border-line bg-white px-3 py-2 text-sm">
        <option value="" <?php if($filterStatus === ''): echo 'selected'; endif; ?>>Semua Status</option>
        <option value="pending" <?php if($filterStatus === 'pending'): echo 'selected'; endif; ?>>Pending</option>
        <option value="paid" <?php if($filterStatus === 'paid'): echo 'selected'; endif; ?>>Paid</option>
        <option value="cancelled" <?php if($filterStatus === 'cancelled'): echo 'selected'; endif; ?>>Cancelled</option>
    </select>
    <button type="submit" class="rounded-lg bg-accent px-4 py-2 text-sm font-medium text-white hover:bg-accent-dark">Cari</button>
</form>

<div class="overflow-hidden rounded-xl border border-line bg-surface">
    <table class="w-full text-left text-sm">
        <thead class="bg-surface-light text-xs uppercase tracking-wide text-ink-muted">
            <tr>
                <th class="px-4 py-3">Order</th>
                <th class="px-4 py-3">Pelanggan</th>
                <th class="px-4 py-3">Item</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-line">
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-4 py-3">
                        <p class="font-medium text-ink"><?php echo e($order->order_number); ?></p>
                        <p class="text-xs text-ink-muted"><?php echo e($order->created_at->format('d M Y, H:i')); ?></p>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-ink"><?php echo e($order->customer_name); ?></p>
                        <p class="text-xs text-ink-muted"><?php echo e($order->customer_phone); ?></p>
                    </td>
                    <td class="px-4 py-3 text-xs text-ink-muted">
                        <?php echo e($order->items->pluck('product_name')->implode(', ')); ?>

                    </td>
                    <td class="px-4 py-3 text-ink-muted">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></td>
                    <td class="px-4 py-3">
                        <form method="POST" action="<?php echo e(route('admin.orders.update', $order)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <select name="status" onchange="this.form.submit()"
                                    class="rounded-lg border border-line bg-white px-2 py-1.5 text-xs">
                                <option value="pending" <?php if($order->status === 'pending'): echo 'selected'; endif; ?>>Pending</option>
                                <option value="paid" <?php if($order->status === 'paid'): echo 'selected'; endif; ?>>Paid</option>
                                <option value="cancelled" <?php if($order->status === 'cancelled'): echo 'selected'; endif; ?>>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="<?php echo e(route('admin.orders.destroy', $order)); ?>"
                              onsubmit="return confirm('Hapus order <?php echo e($order->order_number); ?>?');">
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
                    <td colspan="6" class="px-4 py-10 text-center text-ink-muted">Belum ada pesanan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-4">
    <?php echo e($orders->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>