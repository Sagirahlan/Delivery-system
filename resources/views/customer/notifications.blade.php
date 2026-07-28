@extends('layouts.metronic')

@section('title', 'Notifications')
@section('body_class', 'aside-enabled')
@section('page_title', 'Notifications')
@section('page_subtitle', $unreadCount > 0 ? $unreadCount . ' unread' : 'All caught up!')

@section('sidebar')
    @include('partials.role-sidebar')
@endsection

@section('container_class', 'container-xxl')

@section('content')
<div class="liquid-mesh-container">
<div class="liquid-mesh-bg"></div>

@include('partials.hammshop-promo')

<div class="row g-6">
    <div class="col-lg-8">
        <div class="liquid-glass-card">
            <div class="card-header d-flex justify-content-between align-items-center p-5 pb-0 border-0">
                <h3 class="card-title fw-bolder text-dark fs-4 mb-0">
                    <i class="ki-duotone ki-notification-1 fs-4 me-2 text-primary"><span class="path1"></span><span class="path2"></span></i>
                    All Notifications
                </h3>
                @if($unreadCount > 0)
                <button class="liquid-glass-pill btn-sm" id="mark-all-read">
                    <i class="ki-duotone ki-check-double fs-4 me-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                    Mark All Read
                </button>
                @endif
            </div>
            <div class="card-body p-5">
                @forelse($notifications as $n)
                <div class="d-flex align-items-start gap-3 px-4 py-3 border-bottom {{ $n->read_at ? '' : 'bg-light-primary' }}" data-id="{{ $n->id }}">
                    <div class="symbol symbol-35px mt-1">
                        <div class="symbol-label bg-light-{{ $n->data['type'] === 'order_cancelled' ? 'danger' : ($n->data['type'] === 'order_assigned' ? 'success' : 'warning') }}">
                            @if($n->data['type'] === 'order_cancelled')
                                <i class="ki-duotone ki-cross-circle fs-3 text-danger"><span class="path1"></span><span class="path2"></span></i>
                            @elseif($n->data['type'] === 'order_assigned')
                                <i class="ki-duotone ki-clipboard-check fs-3 text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            @else
                                <i class="ki-duotone ki-clipboard fs-3 text-warning"><span class="path1"></span><span class="path2"></span></i>
                            @endif
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                @if($n->data['type'] === 'status_changed')
                                    <div class="fs-6 text-dark fw-semibold">
                                        Order <span class="font-monospace">{{ $n->data['tracking_number'] }}</span>
                                        status changed to <b class="text-{{ $n->data['new_status'] === 'delivered' ? 'success' : ($n->data['new_status'] === 'cancelled' ? 'danger' : 'warning') }}">{{ ucfirst($n->data['new_status']) }}</b>
                                    </div>
                                @elseif($n->data['type'] === 'order_cancelled')
                                    <div class="fs-6 text-dark fw-semibold">
                                        Order <span class="font-monospace">{{ $n->data['tracking_number'] }}</span> has been cancelled
                                    </div>
                                @elseif($n->data['type'] === 'order_assigned')
                                    <div class="fs-6 text-dark fw-semibold">
                                        New order <span class="font-monospace">{{ $n->data['tracking_number'] }}</span> assigned to you
                                    </div>
                                @else
                                    <div class="fs-6 text-dark fw-semibold">{{ ucfirst($n->data['type'] ?? 'Notification') }}</div>
                                @endif
                                <div class="fs-8 text-muted mt-1">{{ $n->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="d-flex gap-1">
                                @if($n->data['tracking_number'] ?? null)
                                <a href="{{ route('orders.history.detail', $n->data['tracking_number']) }}" class="btn btn-sm btn-icon btn-light" title="View Order">
                                    <i class="ki-duotone ki-eye fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                </a>
                                @endif
                                @if(!$n->read_at)
                                <button class="btn btn-sm btn-icon btn-light btn-mark-read" data-id="{{ $n->id }}" title="Mark as read">
                                    <i class="ki-duotone ki-check fs-3"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                                @endif
                                <button class="btn btn-sm btn-icon btn-light btn-delete-notif" data-id="{{ $n->id }}" title="Delete">
                                    <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-16">
                    <div class="symbol symbol-80px mx-auto mb-5">
                        <div class="symbol-label bg-light d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-notification-off fs-1 text-muted"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <h4 class="fw-bolder text-dark mb-2">No Notifications</h4>
                    <p class="text-muted fs-6">You're all caught up!</p>
                </div>
                @endforelse
            </div>
            @if($notifications->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center py-3">
                <span class="text-muted fs-7">Showing {{ $notifications->firstItem() }}-{{ $notifications->lastItem() }} of {{ $notifications->total() }}</span>
                <div>{{ $notifications->links() }}</div>
            </div>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        <div class="liquid-glass-card">
            <div class="card-header p-5 pb-0 border-0">
                <h3 class="card-title fw-bolder text-dark mb-0">QUICK STATS</h3>
            </div>
            <div class="card-body p-5">
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted fs-6">Unread</span>
                        <span class="fs-3 fw-bolder text-warning">{{ $unreadCount }}</span>
                    </div>
                    <div class="separator my-1"></div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted fs-6">Total</span>
                        <span class="fs-3 fw-bolder text-dark">{{ auth()->user()->notifications()->count() }}</span>
                    </div>
                    <div class="separator my-1"></div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted fs-6">Today</span>
                        <span class="fs-3 fw-bolder text-dark">{{ auth()->user()->notifications()->whereDate('created_at', today())->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    // Mark single as read
    document.querySelectorAll('.btn-mark-read').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch(`/api/notifications/${id}/read`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            }).then(() => location.reload());
        });
    });

    // Mark all as read
    document.getElementById('mark-all-read')?.addEventListener('click', function() {
        fetch('/api/notifications/read-all', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        }).then(() => location.reload());
    });

    // Delete notification
    document.querySelectorAll('.btn-delete-notif').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch(`/api/notifications/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            }).then(() => location.reload());
        });
    });
</script>
@endpush
