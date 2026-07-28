<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('customer')->withCount([
            'orders as total_orders',
            'orders as active_orders' => fn($q) => $q->whereIn('status', ['pending', 'transit']),
        ]);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customers = $query->latest()->paginate(15);
        $stats = [
            'total' => User::role('customer')->count(),
            'active' => User::role('customer')->where('status', 'active')->count(),
            'suspended' => User::role('customer')->where('status', 'suspended')->count(),
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    public function show($id)
    {
        $customer = User::role('customer')->withCount([
            'orders as total_orders',
            'orders as completed_orders' => fn($q) => $q->where('status', 'delivered'),
        ])->findOrFail($id);

        $recentOrders = $customer->orders()->with('agent')->latest()->take(10)->get();
        $totalSpent = $customer->orders()->where('status', 'delivered')->sum('amount');

        return view('admin.customers.show', compact('customer', 'recentOrders', 'totalSpent'));
    }

    public function edit($id)
    {
        $customer = User::role('customer')->findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = User::role('customer')->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'phone' => 'nullable|string|max:20',
        ]);

        $customer->update($request->only('name', 'email', 'phone'));
        if ($request->filled('password')) {
            $customer->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Customer updated.');
    }

    public function suspend($id)
    {
        $customer = User::role('customer')->findOrFail($id);
        $customer->update(['status' => $customer->status === 'suspended' ? 'active' : 'suspended']);
        return back()->with('success', "Customer {$customer->name} status updated.");
    }

    public function destroy($id)
    {
        $customer = User::role('customer')->findOrFail($id);
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted.');
    }
}
