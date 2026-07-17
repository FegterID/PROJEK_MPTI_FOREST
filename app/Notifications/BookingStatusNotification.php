<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusNotification extends Notification
{
    use Queueable;

    public function __construct(protected Booking $booking)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $data = match ($this->booking->status) {
            'confirmed' => [
                'subject'  => 'Invoice Reservasi #' . $this->booking->id . ' — Dikonfirmasi',
                'title'    => 'Reservasi Dikonfirmasi',
                'subtitle' => 'Kabar baik! Tempat Anda telah kami persiapkan dengan baik.',
                'message'  => 'Halo ' . $this->booking->customer_name . ', reservasi Anda di ' . config('site.name') . ' telah **dikonfirmasi** oleh tim kami. Kami tidak sabar untuk memberikan pelayanan terbaik bagi Anda.',
                'action_text' => 'Lihat Reservasi Saya',
                'action_url'  => route('bookings.mine'),
                'footer_note' => 'Ditunggu kedatangannya sesuai jadwal ya. Jika ada perubahan, silakan hubungi kami.'
            ],
            'completed' => [
                'subject'  => 'Terima Kasih! Layanan #' . $this->booking->id . ' Selesai',
                'title'    => 'Layanan Selesai',
                'subtitle' => 'Terima kasih atas kunjungan berharga Anda.',
                'message'  => 'Halo ' . $this->booking->customer_name . ', terima kasih telah menggunakan layanan **' . $this->booking->service_name . '** di ' . config('site.name') . '. Semoga Anda puas dengan perawatan kami!',
                'action_text' => 'Booking Layanan Lagi',
                'action_url'  => route('booking.create'),
                'footer_note' => 'Kami tunggu kunjungan Anda berikutnya untuk tetap tampil memukau.'
            ],
            'cancelled' => [
                'subject'  => 'Reservasi #' . $this->booking->id . ' Dibatalkan',
                'title'    => 'Reservasi Dibatalkan',
                'subtitle' => 'Pemberitahuan pembatalan jadwal layanan.',
                'message'  => 'Halo ' . $this->booking->customer_name . ', reservasi Anda untuk layanan **' . $this->booking->service_name . '** di ' . config('site.name') . ' telah dibatalkan.',
                'action_text' => 'Hubungi via WhatsApp',
                'action_url'  => $this->booking->whatsappLink(),
                'footer_note' => 'Jika pembatalan ini di luar dugaan Anda, silakan hubungi customer service kami segera.'
            ],
            default => [
                'subject'  => 'Invoice Reservasi #' . $this->booking->id . ' — Menunggu Konfirmasi',
                'title'    => 'Reservasi Diterima',
                'subtitle' => 'Permintaan jadwal Anda sedang kami tinjau.',
                'message'  => 'Halo ' . $this->booking->customer_name . ', reservasi Anda di ' . config('site.name') . ' telah kami terima dan saat ini sedang **menunggu konfirmasi** dari tim kami.',
                'action_text' => 'Lihat Reservasi Saya',
                'action_url'  => route('bookings.mine'),
                'footer_note' => 'Kami akan menghubungi Anda kembali begitu reservasi ini dikonfirmasi.'
            ],
        };

        return (new MailMessage)
            ->subject($data['subject'])
            ->view('emails.booking_invoice', [
                'booking' => $this->booking,
                'data'    => $data
            ]);
    }
}
