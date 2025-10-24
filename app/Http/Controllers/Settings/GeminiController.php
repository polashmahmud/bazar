<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GeminiController extends Controller
{
    public function edit()
    {
        return Inertia::render("settings/Gemini");
    }

    public function update(Request $request)
    {
        $request->validate([
            'gemini_api_key' => 'required|string',
        ]);

        $user = auth()->user();
        $user->gemini_api_key = $request->gemini_api_key; // auto encrypt via model
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Gemini API key saved!');
    }
}
