<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Notifications\OrderAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('agent')->withCount([
            'assignedDeliveries as total_deliveries',
            'assignedDeliveries as active_deliveries' => fn($q) => $q->whereIn('status', ['pending', 'transit']),
            'assignedDeliveries as completed_deliveries' => fn($q) => $q->where('status', 'delivered'),
        ]);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%")->orWhere('phone', 'like', "%{$s}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $agents = $query->latest()->paginate(15);
        $stats = [
            'total' => User::role('agent')->count(),
            'active' => User::role('agent')->where('is_available', true)->count(),
            'offline' => User::role('agent')->where('is_available', false)->count(),
            'suspended' => User::role('agent')->where('status', 'suspended')->count(),
        ];

        return view('admin.agents.index', compact('agents', 'stats'));
    }

    public function create()
    {
        return view('admin.agents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $agent = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        $agent->assignRole('agent');

        return redirect()->route('admin.agents.index')->with('success', "Agent {$agent->name} created successfully.");
    }

    public function show($id)
    {
        $agent = User::role('agent')->withCount([
            'assignedDeliveries as total_deliveries',
            'assignedDeliveries as active_deliveries' => fn($q) => $q->whereIn('status', ['pending', 'transit']),
            'assignedDeliveries as completed_deliveries' => fn($q) => $q->where('status', 'delivered'),
        ])->findOrFail($id);

        $recentOrders = $agent->assignedDeliveries()->with('user')->latest()->take(10)->get();
        $totalEarnings = $agent->assignedDeliveries()->where('status', 'delivered')->sum('amount');

        return view('admin.agents.show', compact('agent', 'recentOrders', 'totalEarnings'));
    }

    public function edit($id)
    {
        $agent = User::role('agent')->findOrFail($id);
        return view('admin.agents.edit', compact('agent'));
    }

    public function update(Request $request, $id)
    {
        $agent = User::role('agent')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'phone' => 'nullable|string|max:20',
        ]);

        $agent->update($request->only('name', 'email', 'phone'));
        if ($request->filled('password')) {
            $agent->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.agents.show', $id)->with('success', 'Agent updated.');
    }

    public function suspend($id)
    {
        $agent = User::role('agent')->findOrFail($id);
        $agent->update(['status' => $agent->status === 'suspended' ? 'active' : 'suspended']);
        return back()->with('success', "Agent {$agent->name} status updated.");
    }

    public function destroy($id)
    {
        $agent = User::role('agent')->findOrFail($id);
        $agent->delete();
        return redirect()->route('admin.agents.index')->with('success', 'Agent deleted.');
    }
}
