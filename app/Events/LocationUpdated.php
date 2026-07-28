<?php

namespace App\Events;

use App\Models\Order;
use App\Models\OrderLocation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $location;
    public $trackingNumber;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order, OrderLocation $location)
    {
        $this->order = $order;
        $this->location = $location;
        $this->trackingNumber = $order->tracking_number;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('order.' . $this->order->tracking_number),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'location.updated';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'order_id' => $this->order->id,
            'tracking_number' => $this->trackingNumber,
            'latitude' => $this->location->latitude,
            'longitude' => $this->location->longitude,
            'speed' => $this->location->speed,
            'heading' => $this->location->heading,
            'address' => $this->location->address,
            'status' => $this->order->status,
            'recorded_at' => $this->location->recorded_at->toISOString(),
            'agent' => $this->order->agent ? [
                'id' => $this->order->agent->id,
                'name' => $this->order->agent->name,
            ] : null,
        ];
    }
}
