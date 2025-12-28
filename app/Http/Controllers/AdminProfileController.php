<?php

namespace App\Http\Controllers;

use App\Models\User; // ⬅️ INI KUNCINYA
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    /**
     * Show admin profile
     */
    public function show()
    {
        /** @var User $admin */
        $admin = Auth::user();

        return view('admin-dashboard.profile.index', compact('admin'));
    }

    /**
     * Update admin profile
     */
    public function update(Request $request)
    {
        /** @var User $admin */
        $admin = Auth::user();

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $admin->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data'    => $admin->fresh(),
        ]);
    }

    /**
     * Update admin password
     */
    public function updatePassword(Request $request)
    {
        /** @var User $admin */
        $admin = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password'     => ['required', 'confirmed', Password::min(6)],
        ]);

        if (!Hash::check($validated['current_password'], $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 422);
        }

        $admin->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
        ]);
    }
}
