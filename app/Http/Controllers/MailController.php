<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Mail\MailModel;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportException;


class MailController extends Controller
{
    public function showRecoverPasswordForm()
    {
        return view('pages.recover_password');
    }

    public function sendRecoverPasswordEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $status = 'Error!';
            $message = 'No user found with the provided email address.';
            $request->session()->flash('status', $status);
            $request->session()->flash('message', $message);
            return redirect()->route('recoverPasswordForm');
        }

        $username = $user->username;
        $verificationCode = rand(100000, 999999);

        $mailData = [
            'username' => $username,
            'code' => $verificationCode
        ];

        try {
            Mail::to($request->email)->send(new MailModel($mailData));
            $status = 'Success!';
            $message = 'An email has been sent to ' . $request->email . ' with a verification code.';
        } catch (TransportException $e) {
            $status = 'Error!';
            $message = 'SMTP connection error occurred during the email sending process to ' . $request->email;
        } catch (Exception $e) {
            $status = 'Error!';
            $message = 'An unhandled exception occurred during the email sending process to ' . $request->email . ' ' . $e->getMessage();
        }

        $request->session()->flash('status', $status);
        $request->session()->flash('message', $message);

        if ($status === 'Success!') {
            return redirect()->route('recoverPasswordForm')->with([
                'verificationCode' => $verificationCode,
                'email' => $request->email
            ]);
        }

        return redirect()->route('recoverPasswordForm');
    }

    public function checkResetPassword(Request $request)
    {
        $verificationCode = $request->real_code;
        $enteredCode = $request->code;
        $email = $request->email;

        if ($verificationCode == $enteredCode) {
            return redirect()->route('resetPasswordForm')->with('email', $email);
        }

        $request->session()->flash('status', 'Error!');
        $request->session()->flash('message', 'The verification code you entered is incorrect.');
        return redirect()->route('recoverPasswordForm');
    }

    public function showResetPasswordForm(Request $request)
    {
        if (!$request->session()->has('email')) {
            return redirect()->route('recoverPasswordForm');
        }

        return view('pages.reset_password')->with('email', $request->session()->get('email'));
    }

    public function resetPassword(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $confirmPassword = $request->confirm_password;

        if ($password !== $confirmPassword) {
            $request->session()->flash('status', 'Error!');
            $request->session()->flash('message', 'Passwords do not match.');
            return redirect()->route('resetPasswordForm')->with('email', $email);
        }

        $user = User::where('email', $email)->first();
        $user->password = bcrypt($password);
        $user->save();

        $request->session()->flash('status', 'Success!');
        $request->session()->flash('message', 'Password reset successfully.');
        return redirect()->route('login');
    }
}
