<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;

class OrderInvoiceMail extends Mailable
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this
            ->subject('Invoice Reservasi Forest')
            ->view('emails.order-invoice');
    }
}
