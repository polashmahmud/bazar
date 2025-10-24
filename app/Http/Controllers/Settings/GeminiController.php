<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Gemini\Laravel\Facades\Gemini;

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

        // Test the API key by making a simple API call
        try {
            // Temporarily set the API key for testing
            config(['gemini.api_key' => $request->gemini_api_key]);

            $result = Gemini::generativeModel(model: 'gemini-2.0-flash-exp')
                ->generateContent('Hello');

            // Check if we got a valid response
            if (!$result->text()) {
                return back()->withErrors([
                    'gemini_api_key' => 'API কী সঠিক নয়। দয়া করে একটি বৈধ API কী প্রদান করুন।'
                ])->withInput();
            }

        } catch (\Exception $e) {
            return back()->withErrors([
                'gemini_api_key' => 'API কী যাচাই করতে ব্যর্থ হয়েছে। দয়া করে নিশ্চিত করুন যে আপনার API কী সঠিক।'
            ])->withInput();
        }

        // If validation passed, save the API key
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
