<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $sessionId = Cache::get('session_' . $ip);
       

        if ($sessionId && $request->session()->getId() !== $sessionId) {
            // Session exists for this IP address, and it's not the current session
            return response()->view('welcome', ['sessionId' => $sessionId]);
        }

        Cache::put('session_' . $ip, $request->session()->getId());

        return $next($request);
    }
}
