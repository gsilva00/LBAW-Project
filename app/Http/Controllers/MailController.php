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
        $password = $user->password;

        $mailData = [
            'username' => $username,
            'password' => $password
        ];

        try {
            Mail::to($request->email)->send(new MailModel($mailData));
            $status = 'Success!';
            $message = $request->name . ', an email has been sent to ' . $request->email;
        } catch (TransportException $e) {
            $status = 'Error!';
            $message = 'SMTP connection error occurred during the email sending process to ' . $request->email;
        } catch (Exception $e) {
            $status = 'Error!';
            $message = 'An unhandled exception occurred during the email sending process to ' . $request->email . ' ' . $e->getMessage();
        }

        $request->session()->flash('status', $status);
        $request->session()->flash('message', $message);
        return redirect()->route('recoverPasswordForm');

    }
}
