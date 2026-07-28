<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Default settings definitions.
     */
    protected function getDefaultSettings(): array
    {
        return [
            // Pricing & Fees
            'delivery_fee_base' => [
                'value' => 500,
                'description' => 'Base delivery fee in Naira (NGN)',
            ],
            'fee_small' => [
                'value' => 300,
                'description' => 'Additional fee for small packages (NGN)',
            ],
            'fee_medium' => [
                'value' => 600,
                'description' => 'Additional fee for medium packages (NGN)',
            ],
            'fee_large' => [
                'value' => 1000,
                'description' => 'Additional fee for large packages (NGN)',
            ],
            'fee_fragile' => [
                'value' => 200,
                'description' => 'Additional handling fee for fragile items (NGN)',
            ],
            'service_fee' => [
                'value' => 100,
                'description' => 'Platform service fee per order (NGN)',
            ],

            // Delivery Areas
            'delivery_radius_km' => [
                'value' => 25,
                'description' => 'Maximum delivery radius in kilometers',
            ],
            'delivery_zone_1' => [
                'value' => 'Nasarawa, Sabon Gari, Tarauni',
                'description' => 'Zone 1 coverage areas (comma-separated)',
            ],
            'delivery_zone_2' => [
                'value' => 'Gwale, Fagge, Kano Municipal',
                'description' => 'Zone 2 coverage areas (comma-separated)',
            ],
            'delivery_zone_3' => [
                'value' => 'Dala, Kumbotso, Ungogo',
                'description' => 'Zone 3 coverage areas (comma-separated)',
            ],

            // System Config
            'auto_assign_enabled' => [
                'value' => true,
                'description' => 'Enable automatic order assignment to available agents',
            ],
            'max_orders_per_agent' => [
                'value' => 10,
                'description' => 'Maximum active orders an agent can handle at once',
            ],
            'maintenance_mode' => [
                'value' => false,
                'description' => 'Put the system in maintenance mode (disable new orders)',
            ],
            'registration_enabled' => [
                'value' => true,
                'description' => 'Allow new user registration',
            ],
            'order_tracking_public' => [
                'value' => true,
                'description' => 'Allow public order tracking without login',
            ],
            'estimated_delivery_minutes' => [
                'value' => 30,
                'description' => 'Default estimated delivery time in minutes',
            ],
        ];
    }

    /**
     * Show settings page.
     */
    public function index()
    {
        $defaults = $this->getDefaultSettings();
        $settings = [];

        foreach ($defaults as $key => $default) {
            $settings[$key] = SystemSetting::get($key, $default['value']);
        }

        // Group settings for display
        $pricingSettings = [
            'delivery_fee_base' => ['label' => 'Base Delivery Fee', 'type' => 'number'],
            'fee_small' => ['label' => 'Small Package Fee', 'type' => 'number'],
            'fee_medium' => ['label' => 'Medium Package Fee', 'type' => 'number'],
            'fee_large' => ['label' => 'Large Package Fee', 'type' => 'number'],
            'fee_fragile' => ['label' => 'Fragile Item Fee', 'type' => 'number'],
            'service_fee' => ['label' => 'Service Fee', 'type' => 'number'],
        ];

        $areaSettings = [
            'delivery_radius_km' => ['label' => 'Delivery Radius (km)', 'type' => 'number'],
            'delivery_zone_1' => ['label' => 'Zone 1 Areas', 'type' => 'text'],
            'delivery_zone_2' => ['label' => 'Zone 2 Areas', 'type' => 'text'],
            'delivery_zone_3' => ['label' => 'Zone 3 Areas', 'type' => 'text'],
        ];

        $systemSettings = [
            'auto_assign_enabled' => ['label' => 'Auto-Assign Orders', 'type' => 'boolean'],
            'max_orders_per_agent' => ['label' => 'Max Orders per Agent', 'type' => 'number'],
            'maintenance_mode' => ['label' => 'Maintenance Mode', 'type' => 'boolean'],
            'registration_enabled' => ['label' => 'Allow Registration', 'type' => 'boolean'],
            'order_tracking_public' => ['label' => 'Public Order Tracking', 'type' => 'boolean'],
            'estimated_delivery_minutes' => ['label' => 'Est. Delivery (minutes)', 'type' => 'number'],
        ];

        return view('admin.settings.index', compact(
            'settings',
            'pricingSettings',
            'areaSettings',
            'systemSettings',
            'defaults'
        ));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // Pricing & Fees
            'delivery_fee_base' => 'required|numeric|min:0',
            'fee_small' => 'required|numeric|min:0',
            'fee_medium' => 'required|numeric|min:0',
            'fee_large' => 'required|numeric|min:0',
            'fee_fragile' => 'required|numeric|min:0',
            'service_fee' => 'required|numeric|min:0',

            // Delivery Areas
            'delivery_radius_km' => 'required|numeric|min:1',
            'delivery_zone_1' => 'nullable|string',
            'delivery_zone_2' => 'nullable|string',
            'delivery_zone_3' => 'nullable|string',

            // System Config
            'auto_assign_enabled' => 'nullable|boolean',
            'max_orders_per_agent' => 'required|integer|min:1',
            'maintenance_mode' => 'nullable|boolean',
            'registration_enabled' => 'nullable|boolean',
            'order_tracking_public' => 'nullable|boolean',
            'estimated_delivery_minutes' => 'required|integer|min:5',
        ]);

        $defaults = $this->getDefaultSettings();

        // Handle boolean fields (checkboxes not sent = false)
        $booleanFields = ['auto_assign_enabled', 'maintenance_mode', 'registration_enabled', 'order_tracking_public'];
        foreach ($booleanFields as $field) {
            if (!isset($validated[$field])) {
                $validated[$field] = false;
            }
        }

        // Save each setting
        foreach ($validated as $key => $value) {
            if (isset($defaults[$key])) {
                SystemSetting::set($key, $value, $defaults[$key]['description']);
            }
        }

        SystemSetting::flushCache();

        return back()->with('success', 'Settings updated successfully.');
    }
}
