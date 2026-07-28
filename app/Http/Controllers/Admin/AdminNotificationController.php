<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $stats = [
            'total_customers' => User::role('customer')->count(),
            'total_agents' => User::role('agent')->count(),
        ];
        return view('admin.notifications.index', compact('stats'));
    }

    public function broadcast(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'target' => 'required|in:all,customers,agents',
        ]);

        $users = match ($request->target) {
            'all' => User::all(),
            'customers' => User::role('customer')->get(),
            'agents' => User::role('agent')->get(),
        };

        $sent = 0;
        foreach ($users as $user) {
            $user->notifications()->create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'type' => 'system_announcement',
                'data' => ['message' => $request->message, 'type' => 'system_announcement'],
            ]);
            $sent++;
        }

        return back()->with('success', "Broadcast sent to {$sent} users.");
    }
}
