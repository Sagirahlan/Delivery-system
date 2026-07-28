# WebSocket & Live Tracking Setup Guide

## Overview
SwiftDrop uses **OpenStreetMap (Leaflet)** for mapping and **Laravel Echo + Pusher-compatible WebSocket** server for real-time order tracking.

## Option 1: Local WebSocket Server with Soketi (Recommended for Development)

### 1. Install Soketi (Free, Open-Source Pusher Alternative)

Soketi is a drop-in Pusher replacement that runs locally:

```bash
# Using npm
npm install -g @soketi/soketi

# Or using Docker
docker run -p 6001:6001 -p 9601:9601 quay.io/soketi/soketi:latest-16-alpine
```

### 2. Start Soketi

```bash
soketi start
```

Soketi will listen on:
- `ws://localhost:6001` — WebSocket connections
- `http://localhost:9601` — HTTP API (compatible with Pusher)

### 3. Update .env

```env
PUSHER_APP_ID=delivery-system
PUSHER_APP_KEY=your-pusher-app-key
PUSHER_APP_SECRET=your-pusher-app-secret
PUSHER_APP_CLUSTER=mt1
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http

BROADCAST_CONNECTION=pusher
QUEUE_CONNECTION=database
```

### 4. Start Laravel Queue Worker

```bash
php artisan queue:work
```

### 5. Start Soketi + Laravel Together

```bash
# Terminal 1: Soketi
soketi start

# Terminal 2: Laravel queue + server
php artisan serve
php artisan queue:work
```

---

## Option 2: Pusher Cloud (Production)

1. Create a free account at [pusher.com](https://pusher.com)
2. Create a new app with **Client** events enabled
3. Update your `.env`:

```env
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=eu (or your region)
PUSHER_SCHEME=https
```

---

## How Tracking Works

### Agent broadcasts location:
```
Agent Device → POST /api/orders/{trackingNumber}/location → Laravel
→ Saves to order_locations table
→ Broadcasts via WebSocket → Echo listens in browser → Map updates
```

### Customer sees live updates:
```
Browser → Echo.channel('order.{trackingNumber}')
→ .listen('.location.updated', data) → Move marker on Leaflet map
```

### Testing without WebSocket:
- Use the **Demo Controls** on the tracking page to simulate location updates
- The "Simulate Location Update" button sends an API request and broadcasts via the event system
- For local testing without a WebSocket server, events are logged to the broadcast log

---

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/track/{trackingNumber}` | Live tracking map page |
| GET | `/api/track/{trackingNumber}` | Get location history (JSON) |
| POST | `/api/orders/{trackingNumber}/location` | Update agent location (auth: agent) |
| POST | `/api/orders/{trackingNumber}/status` | Update order status (auth: agent/admin) |
| POST | `/api/orders/{trackingNumber}/simulate` | Simulate location for testing |

---

## Map Features

- **Dark themed** OpenStreetMap via CARTO tiles
- **Draggable markers** for pickup/delivery selection
- **Geolocation** button to use browser GPS
- **Live agent tracking** with animated marker
- **Route history** polyline showing path traveled
- **Real-time status** updates via WebSocket
