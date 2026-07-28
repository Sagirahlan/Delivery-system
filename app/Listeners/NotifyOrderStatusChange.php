<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Notifications\OrderStatusChanged;

class NotifyOrderStatusChange
{
    public function __construct() {}

    public function handle(OrderStatusUpdated $event): void
    {
        $order = $event->order;

        // Notify the customer
        if ($order->user) {
            $order->user->notify(new OrderStatusChanged($order, $event->oldStatus, $event->newStatus));
        }

        // Notify the agent (if different from the one who triggered)
        if ($order->agent) {
            $order->agent->notify(new OrderStatusChanged($order, $event->oldStatus, $event->newStatus));
        }
    }
}
