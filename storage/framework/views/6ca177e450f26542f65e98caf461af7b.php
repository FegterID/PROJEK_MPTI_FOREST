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
            font-size: 13px;
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
            margin-bottom: 35px;
        }

        /* Metadata Ringkasan Atas */
        .meta-table {
            width: 100%;
            margin-bottom: 30px;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #666666;
            border-bottom: 1px solid #EAE5DC;
            padding-bottom: 15px;
        }
        .meta-table td { padding: 4px 0; }
        .meta-value { color: #1A1A1A; font-weight: bold; text-align: right; }

        /* Tabel Rincian Item Invoice */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }
        .invoice-table th {
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #1A1A1A;
            border-bottom: 2px solid #1A1A1A;
            padding: 10px 0;
            text-align: left;
        }
        .invoice-table td {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            padding: 15px 0;
            font-size: 14px;
            border-bottom: 1px solid #F0EAE1;
        }
        .product-name { font-family: 'Georgia', serif; font-weight: bold; color: #1A1A1A; }
        .text-right { text-align: right; }

        /* Ringkasan Total */
        .total-row td { border-bottom: none; padding-top: 10px; padding-bottom: 5px; }
        .grand-total { font-size: 16px; color: #C5A880; font-weight: bold; }

        /* Status Badge */
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
        .status-paid { background-color: #E6F4EA; color: #137333; }
        .status-completed { background-color: #EAF2F8; color: #2980B9; }
        .status-cancelled { background-color: #FCE8E6; color: #C5221F; }

        .divider { border: 0; border-top: 1px solid #EAE5DC; margin: 30px 0; }
        .footer-note { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; color: #666666; line-height: 1.5; font-style: italic; }
        .signature { margin-top: 30px; font-size: 14px; }
        .footer-bottom { text-align: center; padding: 25px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #888888; letter-spacing: 1px; }
    </style>
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <div class="container">

                <!-- HEADER BRAND -->
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="header">
                            <h1 class="brand-name"><?php echo e(config('site.name', 'Septyaa Beauty Bar')); ?></h1>
                            <p class="invoice-title">Official Digital Invoice</p>
                        </td>
                    </tr>
                </table>

                <!-- KONTEN UTAMA -->
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content">
                            <h2 class="greeting"><?php echo e($data['subtitle']); ?></h2>
                            <p class="main-text"><?php echo \Illuminate\Support\Str::markdown($data['message'] ?? ''); ?></p>

                            <!-- METADATA TRANSAKSI -->
                            <table class="meta-table">
                                <tr>
                                    <td>No. Invoice</td>
                                    <td class="meta-value"><?php echo e($order->order_number); ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Transaksi</td>
                                    <td class="meta-value"><?php echo e($order->created_at->format('d M Y H:i')); ?> WIB</td>
                                </tr>
                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td class="meta-value" style="text-transform: uppercase;"><?php echo e($order->payment_method); ?></td>
                                </tr>
                                <tr>
                                    <td>Status Transaksi</td>
                                    <td class="text-right">
                                        <span class="status-badge status-<?php echo e($order->status); ?>">
                                            <?php echo e($order->statusLabel()); ?>

                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <!-- TABEL PRODUK BELANJAAN -->
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-right">Jumlah</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <!-- Gantilah 'product_name' / 'product->name' sesuai properti item Anda -->
                                            <span class="product-name"><?php echo e($item->product->name ?? 'Layanan/Produk Kecantikan'); ?></span>
                                            <br><small style="color: #888;">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></small>
                                        </td>
                                        <td class="text-right" style="color: #666;"><?php echo e($item->quantity); ?>x</td>
                                        <td class="text-right font-weight-bold">Rp <?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <!-- SUB-TOTAL & GRAND TOTAL -->
                                    <tr class="total-row" style="border-top: 1px solid #1A1A1A;">
                                        <td colspan="1"></td>
                                        <td class="text-right" style="color: #666; font-size: 13px;">Subtotal</td>
                                        <td class="text-right">Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></td>
                                    </tr>
                                    <tr class="total-row">
                                        <td colspan="1"></td>
                                        <td class="text-right grand-total">Total Akhir</td>
                                        <td class="text-right grand-total" style="color: #1A1A1A;">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <hr class="divider">

                            <p class="footer-note"><?php echo e($data['footer_note']); ?></p>

                            <div class="signature">
                                Salam hangat,<br>
                                <strong><?php echo e(config('site.name', 'Septyaa Beauty Bar')); ?></strong>
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- FOOTER BAWAH -->
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
<?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/emails/order_invoice.blade.php ENDPATH**/ ?>