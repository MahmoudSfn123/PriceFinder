<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is not logged in
        if (!Auth::check()) {
            return redirect()->route('login.show')
                ->with('info', 'Please log in to access the admin area.');
        }

        $user = Auth::user();

        // Check if user is not admin
        if (!$user->isAdmin()) {
            // Log unauthorized access attempt
            \Log::warning('Unauthorized admin access attempt', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'route' => $request->path()
            ]);

            return redirect()->route('home.index')
                ->with('error', '❌ Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}
