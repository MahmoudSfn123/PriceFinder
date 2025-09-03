<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showSignup()
    {
        return view('auth.signup');
    }

    public function showLogin()
    {
        return view('auth.login');
    }


    public function signup(Request $request)
    {
        // Validation before taking the data
        $validated = $request->validate([
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|confirmed',
            'phone' => 'required|string|regex:/^[0-9]{8,15}$/',
        ]);

        // Hash password and set default role
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'user';
        $validated['is_admin'] = false; // Explicitly set to false for new users

        // Create user
        $user = User::create($validated);

        return to_route('login.show')->with('success', '🎉 Signup Successful! Welcome aboard! Your account has been created successfully.');
    }

   public function login(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string'
    ]);

    // Rate limiting to prevent brute force attacks
    $key = Str::transliterate(Str::lower($validated['email']) . '|' . $request->ip());

    if (RateLimiter::tooManyAttempts($key, 5)) {
        $seconds = RateLimiter::availableIn($key);
        throw ValidationException::withMessages([
            'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
        ]);
    }

    if (Auth::attempt($validated, $request->filled('remember'))) {
        $request->session()->regenerate();

        // Clear rate limiter on successful login
        RateLimiter::clear($key);

        $user = Auth::user();

        // Check if user is admin
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', '✅ Login Successful<br>Welcome Admin!');
        }

        // Check if there's an intended URL to redirect to
        $intendedUrl = $request->session()->get('url.intended');

        if ($intendedUrl) {
            // Clear the intended URL from session
            $request->session()->forget('url.intended');

            // Determine the appropriate success message based on the intended URL
            $successMessage = '✅ Login Successful<br>Welcome back!';

            if (str_contains($intendedUrl, 'products/create') || str_contains($intendedUrl, 'products')) {
                $successMessage = '✅ Login Successful<br>You can now add products!';
            } elseif (str_contains($intendedUrl, 'discussions')) {
                $successMessage = '✅ Login Successful<br>You can now participate in discussions!';
            } elseif (str_contains($intendedUrl, 'admin')) {
                $successMessage = '✅ Login Successful<br>Accessing admin area...';
            }

            return redirect()->to($intendedUrl)
                ->with('success', $successMessage);
        }

        // Default redirect to home if no intended URL
        return redirect()->route('home.index')
            ->with('success', '✅ Login Successful<br>Welcome back!');
    }

    // Record failed attempt
    RateLimiter::hit($key);

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}

    public function logout(Request $request)
    {
        $user = Auth::user();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect based on user type
        if ($user && $user->isAdmin()) {
            return redirect()->route('login.show')
                ->with('info', 'Admin logged out successfully.');
        }

        return redirect()->route('home.index')
            ->with('info', 'Logged out successfully.');
    }
}
