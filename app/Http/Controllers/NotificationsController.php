<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationsController extends Controller
{
    public function showNotificationsPage()
    {
        $user = Auth::user();
        $notifications = $user->notificationsReceived;

        Log::info('Notifications page accessed', ['notifications' => $notifications]);

        return view('pages/notifications_page', ['user' => $user, 'notifications' => $notifications]);
    }
}
