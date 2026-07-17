<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($data['subject']); ?></title>
    <style>
        body {
            font-family: 'Georgia', 'Times New Roman', Times, serif;
            background-color: #FDFBF7;
            color: #2D2D2D;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #FDFBF7;
            padding: 40px 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #FFFFFF;
            border: 1px solid #EAE5DC;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .header {
            background-color: #1A1A1A;
            padding: 40px;
            text-align: center;
        }
        .brand-name {
            font-size: 24px;
            letter-spacing: 4px;
            color: #C5A880;
            text-transform: uppercase;
            margin: 0 0 10px 0;
            font-weight: 300;
        }
        .invoice-title {
            font-size: 14px;
            letter-spacing: 2px;
            color: #FFFFFF;
            text-transform: uppercase;
            margin: 0;
            opacity: 0.8;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 18px;
            color: #1A1A1A;
            margin-bottom: 20px;
        }
        .main-text {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #555555;
            margin-bottom: 30px;
        }
        .invoice-card {
            background-color: #FAF8F5;
            border-left: 3px solid #C5A880;
            padding: 25px;
            margin-bottom: 35px;
        }
        .card-title {
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #1A1A1A;
            margin: 0 0 15px 0;
            font-weight: bold;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 8px 0;
            font-size: 14px;
            vertical-align: top;
        }
        .info-label {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #888888;
            width: 35%;
        }
        .info-value {
            color: #1A1A1A;
            font-weight: bold;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-radius: 2px;
            font-weight: bold;
        }
        .status-pending { background-color: #FDF3E7; color: #E28743; }
        .status-confirmed { background-color: #E6F4EA; color: #137333; }
        .status-completed { background-color: #EAF2F8; color: #2980B9; }
        .status-cancelled { background-color: #FCE8E6; color: #C5221F; }

        .action-container {
            text-align: center;
            margin: 35px 0;
        }
        .btn-luxury {
            display: inline-block;
            background-color: #1A1A1A;
            color: #C5A880 !important;
            text-decoration: none;
            padding: 15px 35px;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: bold;
            border: 1px solid #C5A880;
            transition: all 0.3s ease;
        }
        .divider {
            border: 0;
            border-top: 1px solid #EAE5DC;
            margin: 30px 0;
        }
        .footer-note {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #666666;
            line-height: 1.5;
            font-style: italic;
        }
        .signature {
            margin-top: 30px;
            font-size: 14px;
        }
        .footer-bottom {
            text-align: center;
            padding: 25px;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #888888;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <div class="container">

                <!-- HEADER MAJESTIK -->
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="header">
                            <h1 class="brand-name"><?php echo e(config('site.name', 'Septyaa Beauty Bar')); ?></h1>
                            <p class="invoice-title"><?php echo e($data['title']); ?></p>
                        </td>
                    </tr>
                </table>

                <!-- KONTEN UTAMA -->
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content">
                            <h2 class="greeting"><?php echo e($data['subtitle']); ?></h2>
                            <p class="main-text"><?php echo \Illuminate\Support\Str::markdown($data['message'] ?? ''); ?></p>

                            <!-- STRUKTUR INVOICE KARTU ELEGAN -->
                            <div class="invoice-card">
                                <h3 class="card-title">Ringkasan Detail</h3>
                                <table class="info-table">
                                    <tr>
                                        <td class="info-label">No. Reservasi</td>
                                        <td class="info-value">#<?php echo e($booking->id); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Layanan</td>
                                        <td class="info-value"><?php echo e($booking->service_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Tanggal</td>
                                        <td class="info-value"><?php echo e($booking->booking_date->format('d M Y')); ?></td>
                                    </tr>
                                    <?php if(isset($booking->booking_time)): ?>
                                    <tr>
                                        <td class="info-label">Waktu Jeda</td>
                                        <td class="info-value"><?php echo e($booking->booking_time->format('H:i')); ?> WIB</td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td class="info-label">Status</td>
                                        <td>
                                            <span class="status-badge status-<?php echo e($booking->status); ?>">
                                                <?php echo e($booking->statusLabel()); ?>

                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- TOMBOL UTAMA EMAS/HITAM -->
                            <div class="action-container">
                                <a href="<?php echo e($data['action_url']); ?>" class="btn-luxury">
                                    <?php echo e($data['action_text']); ?>

                                </a>
                            </div>

                            <hr class="divider">

                            <p class="footer-note"><?php echo e($data['footer_note']); ?></p>

                            <div class="signature">
                                Salam hangat,<br>
                                <strong><?php echo e(config('site.name', 'Septyaa Beauty Bar')); ?></strong>
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- FOOTER HAK CIPTA -->
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="footer-bottom">
                            &copy; <?php echo e(date('Y')); ?> <?php echo e(config('site.name')); ?>. All rights reserved.
                        </td>
                    </tr>
                </table>

            </div>
        </td>
    </tr>
</table>

</body>
</html>
<?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/emails/booking_invoice.blade.php ENDPATH**/ ?>