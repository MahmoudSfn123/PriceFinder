<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        logger('✅ Custom Authenticate middleware triggered for: ' . $request->path());

        // Check if user is authenticated first
        if (!Auth::check()) {
            logger('❌ User not authenticated, calling unauthenticated method');
            $response = $this->unauthenticated($request, $guards);
            logger('🔄 Unauthenticated response: ' . get_class($response));
            return $response;
        }

        logger('✅ User authenticated, proceeding to next middleware/controller');
        return $next($request);
    }

    /**
     * Handle unauthenticated users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, array $guards)
    {
        logger('🚫 Unauthenticated method called for path: ' . $request->path());

        if ($request->expectsJson()) {
            logger('📱 JSON request detected, aborting with 401');
            abort(401, 'Unauthenticated.');
        }

        $path = $request->path();
        $message = 'You must log in to continue.';

        if (str_contains($path, 'products/create') || str_contains($path, 'products')) {
            $message = '🛒 You must log in first to add a product.';
        } elseif (str_contains($path, 'discussions')) {
            $message = '💬 Please log in to participate in discussions.';
        } elseif (str_contains($path, 'admin')) {
            $message = '🔒 Admin access requires login.';
        }

        logger('🔄 Redirecting to login with message: ' . $message);
        logger('🔄 Login route exists: ' . (route('login.show') ? 'YES' : 'NO'));

        // Store the intended URL in session (only for GET requests)
        if ($request->isMethod('GET')) {
            $request->session()->put('url.intended', $request->fullUrl());
            logger('💾 Stored intended URL: ' . $request->fullUrl());
        }

        // Create and return the redirect response
        $redirect = redirect()->route('login.show')->with('info', $message);
        logger('🔄 Redirect response created: ' . get_class($redirect));

        return $redirect;
    }
}
