<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('homepage')
                ->withErrors('You cannot create an account while logged in.');
        }
        else {
            return view('auth.register');
        }
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('homepage')
                ->withErrors('You cannot create an account while logged in.');
        }

        try {
            // Validate the request data
            $request->validate([
                'username' => 'required|string|regex:/^[a-zA-Z0-9._-]+$/|max:20|unique:users',
                'email' => 'required|string|email|max:256|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password,
                'display_name' => $request->username
            ]);

            $credentials = $request->only('email', 'password');
            Auth::attempt($credentials);
            $request->session()->regenerate();

            // Redirect to the welcome page with success message
            return redirect()->route('homepage')
                ->withSuccess('You have successfully registered and logged in!');
        }
        catch (Exception $e) {
            // Handle the exception
            return redirect()->back()
                ->withErrors($e->getMessage());
        }
    }
}