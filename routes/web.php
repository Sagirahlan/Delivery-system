<?php

use App\Http\Controllers\Admin\DeliveryAssignmentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Static Pages
Route::get('/about', [\App\Http\Controllers\PageController::class, 'about'])->name('about');
Route::get('/pricing', [\App\Http\Controllers\PageController::class, 'pricing'])->name('pricing');
Route::get('/support', [\App\Http\Controllers\PageController::class, 'support'])->name('support');

/*
|--------------------------------------------------------------------------
| Guest Routes (redirect if already logged in)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Public Routes & Webhooks
|--------------------------------------------------------------------------
*/

// Payment Webhook (outside auth middleware, disable CSRF)
Route::post('/payment/nabroll/webhook', [\App\Http\Controllers\PaymentController::class, 'webhook'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('payment.webhook');

// Public: Place Order (no login required)
Route::get('/orders/place', function () {
    return view('customer.place-order');
})->name('orders.place');
Route::post('/orders/place', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');

// Public: Live Tracking Map by tracking number
Route::get('/track/{trackingNumber?}', [TrackingController::class, 'index'])
    ->name('tracking.map');

// Public: Tracking Location History API
Route::get('/api/track/{trackingNumber}', [TrackingController::class, 'locationHistory'])
    ->name('tracking.history');

// Public: Payment Callback & Retry (no login required)
Route::get('/payment/callback', [\App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/orders/{trackingNumber}/retry-payment', [\App\Http\Controllers\PaymentController::class, 'retryPayment'])->name('orders.payment.retry');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Smart redirect: send user to their role-specific dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard.admin');
        } elseif ($user->hasRole('agent')) {
            return redirect()->route('dashboard.agent');
        }
        return redirect()->route('dashboard.customer');
    })->name('dashboard');

    // Admin Dashboard
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('dashboard.admin');

    // Customer Dashboard
    Route::get('/dashboard/customer', [DashboardController::class, 'customer'])
        ->middleware('role:customer')
        ->name('dashboard.customer');

    // Agent Dashboard
    Route::get('/dashboard/agent', [DashboardController::class, 'agent'])
        ->middleware('role:agent')
        ->name('dashboard.agent');

    // Customer Payment History
    Route::get('/payments/history', [\App\Http\Controllers\PaymentHistoryController::class, 'customerIndex'])
        ->middleware('role:customer')->name('payments.customer');


    // Order History
    Route::get('/orders/history', [\App\Http\Controllers\OrderHistoryController::class, 'index'])
        ->name('orders.history');
    Route::get('/orders/history/{trackingNumber}', [\App\Http\Controllers\OrderHistoryController::class, 'show'])
        ->name('orders.history.detail');
    Route::post('/orders/history/{trackingNumber}/status', [\App\Http\Controllers\OrderHistoryController::class, 'updateStatus'])
        ->middleware('role:admin|agent')
        ->name('orders.history.status');

    // Agent: Update Location (for active deliveries)
    Route::post('/api/orders/{trackingNumber}/location', [TrackingController::class, 'updateLocation'])
        ->middleware('role:agent')
        ->name('tracking.update-location');

    // Agent/Admin: Update Order Status
    Route::post('/api/orders/{trackingNumber}/status', [TrackingController::class, 'updateStatus'])
        ->middleware('role:agent|admin')
        ->name('tracking.update-status');

    // Demo: Simulate Tracking
    Route::post('/api/orders/{trackingNumber}/simulate', [TrackingController::class, 'simulateTracking'])
        ->name('tracking.simulate');

    // C-04: Cancel Order (customer)
    Route::post('/orders/{trackingNumber}/cancel', [\App\Http\Controllers\OrderController::class, 'cancel'])
        ->middleware('role:customer')->name('orders.cancel');

    // C-05: Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'page'])->name('notifications.page');
    Route::get('/api/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.api');
    Route::post('/api/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/api/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/api/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.delete');

    // G-02: Agent Assigned Orders
    Route::get('/agent/orders', [\App\Http\Controllers\AgentOrderController::class, 'index'])
        ->middleware('role:agent')->name('agent.orders');
    Route::post('/agent/orders/{trackingNumber}/accept', [\App\Http\Controllers\AgentOrderController::class, 'accept'])
        ->middleware('role:agent')->name('agent.orders.accept');
    Route::post('/agent/orders/{trackingNumber}/reject', [\App\Http\Controllers\AgentOrderController::class, 'reject'])
        ->middleware('role:agent')->name('agent.orders.reject');
    Route::get('/agent/orders/{trackingNumber}', [\App\Http\Controllers\AgentOrderController::class, 'show'])
        ->middleware('role:agent')->name('agent.orders.show');
    Route::post('/agent/orders/{trackingNumber}/status', [\App\Http\Controllers\AgentOrderController::class, 'updateStatus'])
        ->middleware('role:agent')->name('agent.orders.status');

    /*
    |--------------------------------------------------------------------------
    | Profile Routes (C-06 / G-05)
    |--------------------------------------------------------------------------
    */

    // Profile: View & Update (name, email, phone)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Profile: Change Password
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Profile: Agent Availability Toggle
    Route::post('/profile/availability', [ProfileController::class, 'updateAvailability'])->name('profile.availability');

    // Profile: Customer Saved Addresses
    Route::post('/profile/addresses', [ProfileController::class, 'updateAddresses'])->name('profile.addresses');

    // Handle legacy /account/settings URL or manual entry
    Route::get('/account/settings', function () {
        return redirect()->route('profile.index');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes (All 8 Modules)
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // A-01: Dashboard (via DashboardController@admin → dashboard.admin)

        // A-02: Order Management
        Route::get('/orders', [\App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{trackingNumber}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/{id}/edit', [\App\Http\Controllers\Admin\AdminOrderController::class, 'edit'])->name('orders.edit');
        Route::post('/orders/{id}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{id}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'destroy'])->name('orders.destroy');

        // A-03: Agent Management
        Route::get('/agents', [\App\Http\Controllers\Admin\AgentManagementController::class, 'index'])->name('agents.index');
        Route::get('/agents/create', [\App\Http\Controllers\Admin\AgentManagementController::class, 'create'])->name('agents.create');
        Route::post('/agents', [\App\Http\Controllers\Admin\AgentManagementController::class, 'store'])->name('agents.store');
        Route::get('/agents/{id}', [\App\Http\Controllers\Admin\AgentManagementController::class, 'show'])->name('agents.show');
        Route::get('/agents/{id}/edit', [\App\Http\Controllers\Admin\AgentManagementController::class, 'edit'])->name('agents.edit');
        Route::post('/agents/{id}', [\App\Http\Controllers\Admin\AgentManagementController::class, 'update'])->name('agents.update');
        Route::post('/agents/{id}/suspend', [\App\Http\Controllers\Admin\AgentManagementController::class, 'suspend'])->name('agents.suspend');
        Route::delete('/agents/{id}', [\App\Http\Controllers\Admin\AgentManagementController::class, 'destroy'])->name('agents.destroy');

        // A-04: Customer Management
        Route::get('/customers', [\App\Http\Controllers\Admin\CustomerManagementController::class, 'index'])->name('customers.index');
        Route::get('/customers/{id}', [\App\Http\Controllers\Admin\CustomerManagementController::class, 'show'])->name('customers.show');
        Route::get('/customers/{id}/edit', [\App\Http\Controllers\Admin\CustomerManagementController::class, 'edit'])->name('customers.edit');
        Route::post('/customers/{id}', [\App\Http\Controllers\Admin\CustomerManagementController::class, 'update'])->name('customers.update');
        Route::post('/customers/{id}/suspend', [\App\Http\Controllers\Admin\CustomerManagementController::class, 'suspend'])->name('customers.suspend');
        Route::delete('/customers/{id}', [\App\Http\Controllers\Admin\CustomerManagementController::class, 'destroy'])->name('customers.destroy');

        // A-05: Delivery Assignment
        Route::get('/assignment', [\App\Http\Controllers\Admin\DeliveryAssignmentController::class, 'index'])->name('assignment');
        Route::post('/assignment/{orderId}/assign', [\App\Http\Controllers\Admin\DeliveryAssignmentController::class, 'assign'])->name('assign');
        Route::post('/assignment/{orderId}/reassign', [\App\Http\Controllers\Admin\DeliveryAssignmentController::class, 'reassign'])->name('reassign');

        // A-06: Notifications
        Route::get('/notifications', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'index'])->name('notifications');
        Route::post('/notifications/broadcast', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'broadcast'])->name('notifications.broadcast');

        // A-07: Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::post('/reports/export/orders', [ReportController::class, 'exportOrders'])->name('reports.orders');
        Route::post('/reports/export/revenue', [ReportController::class, 'exportRevenue'])->name('reports.revenue');
        Route::post('/reports/export/agents', [ReportController::class, 'exportAgents'])->name('reports.agents');
        Route::post('/reports/export/customers', [ReportController::class, 'exportCustomers'])->name('reports.customers');

        // A-09: Payment Management
        Route::get('/payments', [\App\Http\Controllers\PaymentHistoryController::class, 'adminIndex'])->name('payments.index');
        Route::get('/wallet', [\App\Http\Controllers\Admin\WalletController::class, 'index'])->name('wallet');

        // A-08: System Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });
});
