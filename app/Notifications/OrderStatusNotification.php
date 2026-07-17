<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Invoice / notifikasi email untuk user setiap kali status pesanan (Order)
 * berubah:
 *  - pending   -> dikirim saat user checkout dari halaman cart
 *  - paid      -> dikirim saat admin konfirmasi pembayaran
 *  - completed -> dikirim saat admin menandai pesanan selesai
 *  - cancelled -> dikirim saat pesanan dibatalkan
 *
 * Dipanggil lewat: $order->notify(new OrderStatusNotification($order));
 * (Order pakai trait Notifiable + routeNotificationForMail() supaya bisa
 * dikirim ke customer_email walau order-nya dibuat oleh guest/tanpa akun.)
 */
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
        return match ($this->order->status) {
            'paid' => $this->confirmedMail(),
            'completed' => $this->completedMail(),
            'cancelled' => $this->cancelledMail(),
            default => $this->pendingMail(),
        };
    }

    protected function pendingMail(): MailMessage
    {
        return (new MailMessage)
            ->subject('Invoice Pesanan '.$this->order->order_number.' — Menunggu Konfirmasi')
            ->greeting('Halo '.$this->order->customer_name.',')
            ->line('Pesananmu di '.config('site.name').' sudah kami terima dan sedang **menunggu konfirmasi pembayaran**.')
            ->line($this->itemsTable())
            ->line('Total: Rp '.number_format($this->order->total, 0, ',', '.'))
            ->action('Hubungi via WhatsApp', config('site.whatsapp'))
            ->line('Silakan selesaikan pembayaran sesuai metode yang dipilih. Tim kami akan mengonfirmasi begitu pembayaran diterima.');
    }

    protected function confirmedMail(): MailMessage
    {
        return (new MailMessage)
            ->subject('Invoice Pesanan '.$this->order->order_number.' — Dikonfirmasi')
            ->greeting('Halo '.$this->order->customer_name.',')
            ->line('Pembayaran untuk pesananmu di '.config('site.name').' sudah **dikonfirmasi**. Terima kasih!')
            ->line($this->itemsTable())
            ->line('Total: Rp '.number_format($this->order->total, 0, ',', '.'))
            ->action('Hubungi via WhatsApp', config('site.whatsapp'))
            ->line('Pesananmu akan segera kami proses.');
    }

    protected function completedMail(): MailMessage
    {
        return (new MailMessage)
            ->subject('Terima Kasih! Pesanan '.$this->order->order_number.' Selesai')
            ->greeting('Halo '.$this->order->customer_name.',')
            ->line('Pesananmu di '.config('site.name').' sudah **selesai** diproses. Terima kasih banyak sudah berbelanja bersama kami!')
            ->line($this->itemsTable())
            ->line('Total: Rp '.number_format($this->order->total, 0, ',', '.'))
            ->action('Belanja Lagi', route('products.index'))
            ->line('Semoga produknya sesuai harapan ya!');
    }

    protected function cancelledMail(): MailMessage
    {
        return (new MailMessage)
            ->subject('Pesanan '.$this->order->order_number.' Dibatalkan')
            ->greeting('Halo '.$this->order->customer_name.',')
            ->line('Mohon maaf, pesananmu di '.config('site.name').' telah **dibatalkan**.')
            ->line($this->itemsTable())
            ->action('Hubungi via WhatsApp', config('site.whatsapp'))
            ->line('Kalau ini di luar dugaanmu, silakan hubungi kami.');
    }

    /**
     * Rincian item pesanan dalam bentuk tabel markdown (dirender otomatis
     * jadi tabel HTML oleh mail Laravel). Pastikan $order->items sudah
     * di-load (eager load) sebelum notifikasi ini dikirim.
     */
    protected function itemsTable(): string
    {
        $rows = $this->order->items->map(function ($item) {
            return sprintf(
                '| %s | %d | Rp %s |',
                $item->product_name,
                $item->quantity,
                number_format($item->subtotal, 0, ',', '.')
            );
        })->implode("\n");

        return "| Produk | Qty | Subtotal |\n| :--- | :---: | ---: |\n".$rows;
    }
}
