<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the profile edit page.
     */
    public function index()
    {
        $user = auth()->user();
        $roles = $user->getRoleNames();
        $savedAddresses = $user->delivery_addresses ?? [];

        return view('profile.index', compact('user', 'roles', 'savedAddresses'));
    }

    /**
     * Update profile (name, email, phone, avatar).
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Change password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'password_confirmation' => ['required', 'string'],
        ]);

        if (!Hash::check($validated['current_password'], $request->user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password changed successfully.');
    }

    /**
     * Toggle agent availability (on/off duty).
     */
    public function updateAvailability(Request $request)
    {
        $user = $request->user();

        if (!$user->hasRole('agent')) {
            abort(403, 'Only agents can update their availability status.');
        }

        $validated = $request->validate([
            'is_available' => ['required', 'boolean'],
        ]);

        $user->update(['is_available' => (bool) $validated['is_available']]);

        return redirect()->route('profile.index')
            ->with('success', $validated['is_available'] ? 'You are now on duty.' : 'You are now off duty.');
    }

    /**
     * Update saved delivery addresses (customers only).
     */
    public function updateAddresses(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'addresses' => ['required', 'array'],
            'addresses.*.label' => ['required', 'string', 'max:100'],
            'addresses.*.address' => ['required', 'string', 'max:500'],
        ]);

        $user->update([
            'delivery_addresses' => $validated['addresses'],
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Saved addresses updated successfully.');
    }
}
