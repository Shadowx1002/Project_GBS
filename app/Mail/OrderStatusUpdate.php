<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $oldStatus;
    public $newStatus;

    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function build()
    {
        return $this->subject('Order Status Update - ' . $this->order->order_number)
                    ->view('emails.order-status-update')
                    ->with([
                        'order' => $this->order,
                        'oldStatus' => $this->oldStatus,
                        'newStatus' => $this->newStatus
                    ]);
    }
}