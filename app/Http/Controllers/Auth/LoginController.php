<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display a login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        try {
            $this->authorize('login', User::class);
        }
        catch (AuthorizationException $e) {
            return redirect()->route('homepage')
                ->withErrors('You are already logged in.');
        }

        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        try {
            $this->authorize('login', User::class);
        }
        catch (AuthorizationException $e) {
            return redirect()->route('homepage')
                ->withErrors('You are already logged in.');
        }

        $credentials = $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);

        $login = $credentials['login'];
        $password = $credentials['password'];

        // Determine if the login input is an email or a username
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $login, 'password' => $password], $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('homepage'))
                ->withSuccess('You have logged in successfully!');
        }

        return redirect()->back()
            ->withErrors('The provided credentials do not match our records.');
    }

    /**
     * Log out the user from application.
     */
    public function logout(Request $request): RedirectResponse
    {
        try {
            $this->authorize('logout', User::class);
        }
        catch (AuthorizationException $e) {
            return redirect()->route('login');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('homepage')
            ->withSuccess('You have logged out successfully!');
    }
}