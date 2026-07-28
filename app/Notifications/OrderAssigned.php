<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderAssigned extends Notification
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
            ->subject("New Order Assigned: {$this->order->tracking_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("You have been assigned a new delivery: **{$this->order->tracking_number}**")
            ->line("Pickup: {$this->order->pickup_address}")
            ->line("Delivery: {$this->order->delivery_address}")
            ->action('View Order', url("/track/{$this->order->tracking_number}"))
            ->line('Thank you for your hard work!');
    }

    public function toArray($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'tracking_number' => $this->order->tracking_number,
            'pickup_address' => $this->order->pickup_address,
            'delivery_address' => $this->order->delivery_address,
            'type' => 'order_assigned',
        ];
    }
}
