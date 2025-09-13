<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PinLoginController extends Controller
{
    /**
     * Show the pin login form
     */
    public function show()
    {
        return Inertia::render('Auth/PinLogin');
    }

    /**
     * Handle pin login attempt
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pin_code' => 'required|digits:4',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if user has pin code set
        if (!$user->hasPinCode()) {
            throw ValidationException::withMessages([
                'pin_code' => ['Pin code is not set for this account. Please login with email and password first.'],
            ]);
        }

        // Verify pin code
        if (!$user->verifyPinCode($request->pin_code)) {
            throw ValidationException::withMessages([
                'pin_code' => ['The provided pin code is incorrect.'],
            ]);
        }

        // Log the user in
        Auth::login($user, true);

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    /**
     * Show pin setup form
     */
    public function showSetup()
    {
        return Inertia::render('Auth/PinSetup');
    }

    /**
     * Handle pin setup
     */
    public function setup(Request $request)
    {
        $request->validate([
            'pin_code' => 'required|digits:4|confirmed',
        ]);

        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $user->setPinCode($request->pin_code);

        return redirect()->route('dashboard')->with('success', 'Pin code set successfully!');
    }

    /**
     * Remove pin code
     */
    public function remove(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $user->removePinCode();

        return back()->with('success', 'Pin code removed successfully!');
    }
}
