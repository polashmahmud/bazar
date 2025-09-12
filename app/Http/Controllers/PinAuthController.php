<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class PinAuthController extends Controller
{
    public function showPinForm()
    {
        // If already authenticated, redirect to items
        if (Auth::check()) {
            return redirect()->route('items.index');
        }

        return Inertia::render('PinLogin');
    }

    public function verifyPin(Request $request)
    {
        $request->validate([
            'pin' => 'required|string|size:4'
        ]);

        $pin = $request->input('pin');
        
        // Check if PIN is correct
        if ($pin === '0476') {
            // Find or create a default user for PIN authentication
            $user = User::firstOrCreate(
                ['email' => 'pin@grocery.app'],
                [
                    'name' => 'Grocery User',
                    'password' => Hash::make('secure_password_for_pin_user'),
                    'email_verified_at' => now(),
                ]
            );

            // Log the user in
            Auth::login($user, true); // true for remember

            return response()->json([
                'success' => true,
                'redirect' => route('items.index')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Incorrect PIN. Please try again.'
        ], 422);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('pin.form');
    }
}
