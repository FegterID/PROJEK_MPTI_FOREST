<!DOCTYPE html>
<html>

<head>
    <title>Invoice Pesanan</title>
</head>

<body>

    <h2>Invoice Pesanan</h2>

    <p>Halo <?php echo e($order->user->name); ?></p>

    <p>Pesanan Anda telah berhasil dibuat.</p>

    <p>Status :
        <strong><?php echo e(ucfirst($order->status)); ?></strong>
    </p>

    <p>Total :
        Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?>

    </p>

    <?php if($order->status == 'pending'): ?>
        <p>Pesanan sedang menunggu konfirmasi admin.</p>
    <?php endif; ?>

    <?php if($order->status == 'confirmed'): ?>
        <p>Pesanan telah dikonfirmasi.</p>
    <?php endif; ?>

    <?php if($order->status == 'completed'): ?>
        <p>Terima kasih telah berbelanja di Forest 🌿</p>
    <?php endif; ?>

</body>

</html>
<?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/emails/order-invoice.blade.php ENDPATH**/ ?>