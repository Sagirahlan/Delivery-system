<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification
{
    use Queueable;

    public $order;
    public $oldStatus;
    public $newStatus;

    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Order {$this->order->tracking_number} — Status Updated")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your order **{$this->order->tracking_number}** status has changed from '{$this->oldStatus}' to '**{$this->newStatus}**'.")
            ->action('Track Order', url("/track/{$this->order->tracking_number}"))
            ->line('Thank you for using SwiftDrop!');
    }

    public function toArray($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'tracking_number' => $this->order->tracking_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'type' => 'status_changed',
        ];
    }
}
