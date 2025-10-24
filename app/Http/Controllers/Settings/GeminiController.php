<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GeminiController extends Controller
{
    public function edit()
    {
        return Inertia::render('settings/Gemini');
    }

    public function update(Request $request)
    {
        $request->validate([
            'gemini_api_key' => 'required|string',
        ]);

        $request->user()->update([
            'gemini_api_key' => $request->gemini_api_key,
        ]);

        return back()->with('success', 'Gemini API key সফলভাবে সংরক্ষণ করা হয়েছে।');
    }

    public function destroy(Request $request)
    {
        $request->user()->update([
            'gemini_api_key' => null,
        ]);

        return back()->with('success', 'Gemini API key সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
