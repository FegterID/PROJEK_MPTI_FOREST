<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client; // Pastikan install SDK Twilio jika pakai Twilio: composer require twilio/sdk

class OrderProcessed extends Notification
{
    use Queueable;

    protected $orderData;

    // Memasukkan data yang mau dikirim ke dalam constructor
    public function __construct($orderData)
    {
        $this->orderData = $orderData;
    }

    // Menentukan channel apa saja yang dipakai
    public function via($notifiable)
    {
        return ['mail', 'whatsapp'];
    }

    // Setup format Email
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Pesanan Anda Diproses!')
                    ->greeting('Halo ' . $notifiable->name)
                    ->line('Pesanan dengan ID #' . $this->orderData['id'] . ' sedang kami proses.')
                    ->action('Lihat Pesanan', url('/orders/' . $this->orderData['id']))
                    ->line('Terima kasih telah berbelanja!');
    }

    // Setup format & logika WhatsApp (Contoh menggunakan Twilio)
    public function toWhatsapp($notifiable)
    {
        // Laravel otomatis tahu $notifiable->routeNotificationForWhatsapp()
        // akan mengambil data dari kolom 'username' berkat setup di Model tadi
        $to = $notifiable->routeNotificationForWhatsapp($this);

        $message = "Halo " . $notifiable->name . ", pesanan Anda #" . $this->orderData['id'] . " sedang diproses!";

        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_WHATSAPP_NUMBER');

        $twilio = new Client($sid, $token);

        return $twilio->messages->create(
            "whatsapp:" . $to,
            [
                "from" => "whatsapp:" . $from,
                "body" => $message
            ]
        );
    }
}
