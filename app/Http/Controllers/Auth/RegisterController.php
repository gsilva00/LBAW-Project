<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            // Validate the request data
           $request->validate([
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'display_name' => $request->username
            ]);

            $credentials = $request->only('email', 'password');
            Auth::attempt($credentials);
            $request->session()->regenerate();

            // Redirect to the welcome page with success message
            return redirect()->route('homepage')
                ->withSuccess('You have successfully registered & logged in!');
        } catch (Exception $e) {
            // Handle the exception
            Log::error('Registration error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}