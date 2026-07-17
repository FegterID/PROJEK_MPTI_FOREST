<h2>Invoice Reservasi</h2>

<p>Halo <?php echo e($booking->customer_name); ?></p>

<p>Berikut informasi reservasi Anda.</p>

<table border="1" cellpadding="8">
    <tr>
        <td>No Booking</td>
        <td>#<?php echo e($booking->id); ?></td>
    </tr>

    <tr>
        <td>Layanan</td>
        <td><?php echo e($booking->service_name); ?></td>
    </tr>

    <tr>
        <td>Tanggal</td>
        <td><?php echo e($booking->booking_date); ?></td>
    </tr>

    <tr>
        <td>Jam</td>
        <td><?php echo e($booking->booking_time); ?></td>
    </tr>

    <tr>
        <td>Status</td>
        <td><?php echo e($booking->statusLabel()); ?></td>
    </tr>
</table>

<?php if($booking->status == 'pending'): ?>

    <p>
        Reservasi telah diterima dan sedang menunggu konfirmasi admin.
    </p>

<?php endif; ?>

<?php if($booking->status == 'confirmed'): ?>

    <p>
        Reservasi Anda telah dikonfirmasi.
        Silakan datang sesuai jadwal.
    </p>

<?php endif; ?>

<?php if($booking->status == 'completed'): ?>

    <p>
        Terima kasih telah menggunakan layanan Forest 🌿
        Semoga kami dapat melayani Anda kembali.
    </p>

<?php endif; ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/emails/booking-invoice.blade.php ENDPATH**/ ?>