<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureGeminiKeySet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return $next($request);
        }

        if (empty($user->gemini_api_key)) {
            if (! $request->is('settings/gemini')) {
                return redirect()->route('settings.gemini')->with('warning', 'Please set your Gemini API key to access this feature.');
            }
        }

        return $next($request);
    }
}
