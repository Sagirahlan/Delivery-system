<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration.
     * All self-registered users are assigned the 'customer' role.
     * Agent and Admin accounts are managed by admins only.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // All self-registration is customer-only
        $user->assignRole('customer');

        Auth::login($user);

        $pendingRedirect = \App\Http\Controllers\OrderController::processPendingOrder($user);
        if ($pendingRedirect) {
            return $pendingRedirect;
        }

        return redirect()->route('dashboard')->with('success', 'Welcome to HMLL! Your account has been created.');
    }
}
