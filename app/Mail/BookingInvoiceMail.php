<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Mail\Mailable;

class BookingInvoiceMail extends Mailable
{
    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this
            ->subject('Invoice Reservasi Forest')
            ->view('emails.booking-invoice');
    }
}
