<?php $__env->startSection('title', 'Orders'); ?>

<?php $__env->startSection('content'); ?>
<!-- SUB-HEADER INFORMASIONAL -->
<div class="mb-6">
    <p class="text-xs text-ink-muted">Pantau log transaksi masuk, konfirmasi pembayaran dari pelanggan, serta kelola rekam jejak pesanan produk ritel.</p>
</div>

<!-- TOP STATS CARDS (GRID OF 4) - DISPANDU DENGAN WARNA SEMANTIK YANG KONSISTEN -->
<div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-4 sm:gap-6">
    <div class="rounded-2xl border border-line bg-surface p-5 text-center transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-muted/80">Total Pesanan</p>
        <p class="mt-2 text-2xl font-bold tracking-tight text-ink"><?php echo e(str_pad($totalOrders, 2, '0', STR_PAD_LEFT)); ?></p>
    </div>
    <div class="rounded-2xl border border-line bg-surface p-5 text-center transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-muted/80">Sudah Dibayar</p>
        <p class="mt-2 text-2xl font-bold tracking-tight text-emerald-600"><?php echo e(str_pad($paidOrders, 2, '0', STR_PAD_LEFT)); ?></p>
    </div>
    <div class="rounded-2xl border border-line bg-surface p-5 text-center transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-muted/80">Menunggu</p>
        <p class="mt-2 text-2xl font-bold tracking-tight text-amber-500"><?php echo e(str_pad($pendingOrders, 2, '0', STR_PAD_LEFT)); ?></p>
    </div>
    <div class="rounded-2xl border border-line bg-surface p-5 text-center transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-muted/80">Selesai</p>
        <p class="mt-2 text-2xl font-bold tracking-tight text-sky-600"><?php echo e(str_pad($completedOrders, 2, '0', STR_PAD_LEFT)); ?></p>
    </div>
</div>

<!-- BAR ALAT: FITUR PENCARIAN DENGAN INTEGRASI FILTER KONSISTEN -->
<form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center">
    <!-- Menjaga status filter badge tetap aktif saat form pencarian disubmit -->
    <?php if($filterStatus): ?>
        <input type="hidden" name="status" value="<?php echo e($filterStatus); ?>">
    <?php endif; ?>

    <!-- Input Search Box Component -->
    <div class="relative flex-1">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-ink-muted/70">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
        <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari nomor order / nama pelanggan..."
               class="w-full rounded-xl border border-line bg-surface pl-10 pr-4 py-2 text-xs font-medium text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
    </div>

    <!-- Action Button -->
    <button type="submit" class="rounded-xl bg-accent px-5 py-2 text-xs font-bold text-white shadow-sm shadow-accent/20 transition-all hover:opacity-90 active:scale-95">
        Cari Data
    </button>
</form>

<!-- FILTER STATUS BERBENTUK BADGE MODERN (DENGAN INPUT PENCARIAN TERJAGA) -->
<div class="mb-6 flex flex-wrap gap-2">
    <a href="<?php echo e(route('admin.orders.index', request()->only(['q']))); ?>"
       class="rounded-xl px-4 py-2 text-xs font-semibold tracking-wide transition-all duration-200
       <?php echo e($filterStatus === '' ? 'bg-accent text-white shadow-sm shadow-accent/20' : 'border border-line bg-surface text-ink hover:border-accent'); ?>">
        Semua Data
    </a>
    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('admin.orders.index', array_merge(request()->only(['q']), ['status' => $status]))); ?>"
           class="rounded-xl px-4 py-2 text-xs font-semibold tracking-wide transition-all duration-200
           <?php echo e($filterStatus === $status ? 'bg-accent text-white shadow-sm shadow-accent/20' : 'border border-line bg-surface text-ink hover:border-accent'); ?>">
            <?php echo e(\App\Models\Order::STATUS_LABELS[$status] ?? ucfirst($status)); ?>

        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- PREMIUM CONSOLE TABLE LAYOUT -->
<div class="overflow-hidden rounded-2xl border border-line bg-surface shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-surface-light/60 text-[10px] font-bold uppercase tracking-wider text-ink-muted/80 border-b border-line">
                <tr>
                    <th class="px-6 py-4">Order</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Item Produk</th>
                    <th class="px-6 py-4">Total Belanja</th>
                    <th class="px-6 py-4">Ubah Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line/60">
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-surface-light/30 transition-colors duration-150">
                        <!-- Order Number (Monospace) -->
                        <td class="px-6 py-4">
                            <span class="block font-mono text-xs font-semibold tracking-tight text-ink"><?php echo e($order->order_number); ?></span>
                            <span class="block text-[10px] text-ink-muted/80 mt-0.5"><?php echo e($order->created_at->format('d M Y &middot; H:i')); ?></span>
                        </td>

                        <!-- Customer Details -->
                        <td class="px-6 py-4">
                            <span class="block font-medium text-ink text-xs tracking-tight"><?php echo e($order->customer_name); ?></span>
                            <span class="block font-mono text-[10px] text-ink-muted/80 mt-0.5"><?php echo e($order->customer_phone); ?></span>
                        </td>

                        <!-- Embedded Item Strings -->
                        <td class="px-6 py-4">
                            <span class="block text-xs text-ink-muted max-w-xs truncate font-medium" title="<?php echo e($order->items->pluck('product_name')->implode(', ')); ?>">
                                <?php echo e($order->items->pluck('product_name')->implode(', ')); ?>

                            </span>
                        </td>

                        <!-- Total Price Currency -->
                        <td class="px-6 py-4 text-xs font-bold text-ink">
                            Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?>

                        </td>

                        <!-- Status Update (Inline Form Select Fixed) -->
                        <td class="px-6 py-4">
                            <form method="POST" action="<?php echo e(route('admin.orders.update', $order)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <div class="relative inline-block w-full min-w-[130px]">
                                    <select name="status" onchange="this.form.submit()"
                                            class="w-full appearance-none rounded-xl border border-line bg-surface px-3 py-1.5 text-xs font-medium text-ink shadow-sm transition-all focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent pr-8">
                                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status); ?>" <?php if($order->status === $status): echo 'selected'; endif; ?>>
                                                <?php echo e(\App\Models\Order::STATUS_LABELS[$status] ?? ucfirst($status)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-ink-muted">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </form>
                        </td>

                        <!-- Destructive Destroy Action -->
                        <td class="px-6 py-4 text-right">
                            <form method="POST" action="<?php echo e(route('admin.orders.destroy', $order)); ?>"
                                  onsubmit="return confirm('Hapus entri log order <?php echo e($order->order_number); ?>?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="inline-flex items-center gap-1 rounded-xl border border-rose-200 bg-white px-3 py-1.5 text-xs font-medium text-rose-600 shadow-sm transition-all hover:bg-rose-50 hover:border-rose-300">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-xs text-ink-muted">Belum ada riwayat transaksi ritel produk masuk.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- PAGINASI KUSTOM KONSOL -->
<div class="mt-6">
    <?php echo e($orders->appends(request()->query())->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>