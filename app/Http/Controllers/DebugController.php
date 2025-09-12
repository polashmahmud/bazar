<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DebugController extends Controller
{
    public function logFrontendError(Request $request)
    {
        Log::info('Frontend Debug Info', [
            'type' => $request->type,
            'message' => $request->message,
            'data' => $request->data,
            'timestamp' => now(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json(['logged' => true]);
    }
}
