<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
{
    use Queueable;

    public function __construct(protected Order $order)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $data = match ($this->order->status) {
            'paid' => [
                'subject'     => 'Pembayaran Berhasil — Order #' . $this->order->order_number,
                'title'       => 'Pembayaran Dikonfirmasi',
                'subtitle'    => 'Terima kasih, pembayaran Anda telah kami terima.',
                'message'     => 'Halo ' . $this->order->customer_name . ', pembayaran untuk pesanan **' . $this->order->order_number . '** telah berhasil dikonfirmasi. Tim kami sedang menyiapkan produk terbaik untuk dikirimkan ke alamat Anda.',
                'footer_note' => 'Nomor resi pengiriman akan kami informasikan begitu paket diserahkan ke kurir.'
            ],
            'completed' => [
                'subject'     => 'Pesanan Selesai — Order #' . $this->order->order_number,
                'title'       => 'Pesanan Selesai',
                'subtitle'    => 'Paket Anda telah sampai di tujuan.',
                'message'     => 'Halo ' . $this->order->customer_name . ', pesanan **' . $this->order->order_number . '** dinyatakan telah selesai. Terima kasih telah berbelanja di ' . config('site.name') . ', semoga produk kami memuaskan Anda!',
                'footer_note' => 'Kami tunggu pesanan Anda berikutnya untuk selalu tampil memukau.'
            ],
            'cancelled' => [
                'subject'     => 'Pembatalan Pesanan — Order #' . $this->order->order_number,
                'title'       => 'Pesanan Dibatalkan',
                'subtitle'    => 'Pemberitahuan pembatalan pesanan Anda.',
                'message'     => 'Halo ' . $this->order->customer_name . ', dengan berat hati kami menginformasikan bahwa pesanan **' . $this->order->order_number . '** telah dibatalkan.',
                'footer_note' => 'Jika pembatalan ini terjadi karena ketidaksengajaan, silakan hubungi Customer Service kami segera.'
            ],
            default => [ // pending
                'subject'     => 'Invoice Pesanan #' . $this->order->order_number . ' — Menunggu Pembayaran',
                'title'       => 'Pesanan Diterima',
                'subtitle'    => 'Terima kasih atas pesanan berharga Anda.',
                'message'     => 'Halo ' . $this->order->customer_name . ', pesanan Anda dengan nomor **' . $this->order->order_number . '** telah kami terima. Silakan lakukan penyelesaian pembayaran sesuai metode pilihan Anda agar kami dapat langsung memprosesnya.',
                'footer_note' => 'Abaikan pesan ini jika Anda sudah menyelesaikan proses pembayaran Anda.'
            ],
        };

        return (new MailMessage)
            ->subject($data['subject'])
            ->view('emails.order_invoice', [
                'order' => $this->order,
                'data'  => $data
            ]);
    }
}
