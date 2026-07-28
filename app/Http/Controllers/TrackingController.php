<?php

namespace App\Http\Controllers;

use App\Events\LocationUpdated;
use App\Events\OrderStatusUpdated;
use App\Models\Order;
use App\Models\OrderLocation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    /**
     * Show the live tracking map page.
     */
    public function index($trackingNumber = null)
    {
        $order = null;

        if ($trackingNumber) {
            $order = Order::with(['agent', 'latestLocation'])
                ->where('tracking_number', $trackingNumber)
                ->firstOrFail();
        }

        return view('tracking.map', compact('order'));
    }

    /**
     * Get order location history via API.
     */
    public function locationHistory($trackingNumber): JsonResponse
    {
        $order = Order::where('tracking_number', $trackingNumber)->firstOrFail();

        $locations = OrderLocation::forOrder($order->id)
            ->latestFirst()
            ->limit(100)
            ->get();

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'tracking_number' => $order->tracking_number,
                'status' => $order->status,
                'pickup_address' => $order->pickup_address,
                'delivery_address' => $order->delivery_address,
                'pickup_lat' => $order->pickup_lat,
                'pickup_lng' => $order->pickup_lng,
                'delivery_lat' => $order->delivery_lat,
                'delivery_lng' => $order->delivery_lng,
            ],
            'locations' => $locations->map(fn($loc) => [
                'latitude' => (float) $loc->latitude,
                'longitude' => (float) $loc->longitude,
                'speed' => (float) $loc->speed,
                'heading' => $loc->heading,
                'address' => $loc->address,
                'recorded_at' => $loc->recorded_at->toISOString(),
            ]),
        ]);
    }

    /**
     * Update agent's current location (called by agent app/device).
     */
    public function updateLocation(Request $request, $trackingNumber): JsonResponse
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'speed' => 'nullable|numeric|min:0',
            'heading' => 'nullable|string|in:N,NE,E,SE,S,SW,W,NW',
            'address' => 'nullable|string|max:500',
        ]);

        $order = Order::where('tracking_number', $trackingNumber)
            ->where('agent_id', Auth::id())
            ->firstOrFail();

        if (!$order->isInTransit()) {
            return response()->json([
                'success' => false,
                'message' => 'Order is not currently in transit.',
            ], 400);
        }

        // Save location record
        $location = OrderLocation::create([
            'order_id' => $order->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'speed' => $request->speed ?? 0,
            'heading' => $request->heading,
            'address' => $request->address,
            'recorded_at' => now(),
        ]);

        // Update order's current location
        $order->update([
            'current_lat' => $request->latitude,
            'current_lng' => $request->longitude,
        ]);

        // Broadcast the update via WebSocket
        event(new LocationUpdated($order, $location));

        return response()->json([
            'success' => true,
            'message' => 'Location updated successfully.',
            'location' => $location,
        ]);
    }

    /**
     * Update order status (with broadcast).
     */
    public function updateStatus(Request $request, $trackingNumber): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,transit,delivered,cancelled',
        ]);

        $order = Order::where('tracking_number', $trackingNumber)->firstOrFail();

        // Authorization
        $user = Auth::user();
        if ($order->agent_id !== $user->id && !$user->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update order status.',
            ], 403);
        }

        $oldStatus = $order->status;
        $newStatus = $request->status;

        if ($oldStatus === $newStatus) {
            return response()->json([
                'success' => false,
                'message' => 'Order is already in this status.',
            ], 400);
        }

        $order->update(['status' => $newStatus]);

        // Set estimated arrival when going into transit
        if ($newStatus === Order::STATUS_TRANSIT) {
            $order->update([
                'estimated_arrival' => now()->addMinutes(15),
            ]);
        }

        // Broadcast the status change
        event(new OrderStatusUpdated($order, $oldStatus, $newStatus));

        return response()->json([
            'success' => true,
            'message' => "Order status updated from '{$oldStatus}' to '{$newStatus}'.",
            'order' => $order->only(['id', 'tracking_number', 'status', 'estimated_arrival']),
        ]);
    }

    /**
     * Simulate location updates for demo/testing.
     */
    public function simulateTracking($trackingNumber): JsonResponse
    {
        $order = Order::where('tracking_number', $trackingNumber)->firstOrFail();

        if (!$order->pickup_lat || !$order->delivery_lat) {
            return response()->json([
                'success' => false,
                'message' => 'Order does not have pickup/delivery coordinates.',
            ], 400);
        }

        // Generate a midpoint location
        $midLat = ($order->pickup_lat + $order->delivery_lat) / 2;
        $midLng = ($order->pickup_lng + $order->delivery_lng) / 2;

        $location = OrderLocation::create([
            'order_id' => $order->id,
            'latitude' => $midLat + (rand(-50, 50) / 10000),
            'longitude' => $midLng + (rand(-50, 50) / 10000),
            'speed' => rand(20, 60),
            'heading' => ['N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW'][rand(0, 7)],
            'address' => 'En route to destination',
            'recorded_at' => now(),
        ]);

        $order->update([
            'current_lat' => $location->latitude,
            'current_lng' => $location->longitude,
        ]);

        event(new LocationUpdated($order, $location));

        return response()->json([
            'success' => true,
            'location' => $location,
        ]);
    }
}
