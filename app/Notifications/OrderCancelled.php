<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCancelled extends Notification
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Order Cancelled: {$this->order->tracking_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your order **{$this->order->tracking_number}** has been cancelled.")
            ->line("If you did not request this cancellation, please contact support.")
            ->action('View Orders', url('/orders/history'))
            ->line('Thank you for using SwiftDrop!');
    }

    public function toArray($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'tracking_number' => $this->order->tracking_number,
            'type' => 'order_cancelled',
        ];
    }
}
