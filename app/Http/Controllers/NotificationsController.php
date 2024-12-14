<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationsController extends Controller
{
    public function showNotificationsPage()
    {
        $user = Auth::user();
        $notifications = Notification::getUnviewedNotificationsForUser($user);

        return view('pages/notifications_page', ['user' => $user, 'notifications' => $notifications]);
    }

    public function newComments()
    {
        $user = Auth::user();
        $notifications = Notification::getUnviewedNotificationsForUser($user);

        Log::info('New comments accessed', ['notifications' => $notifications]);

        return view('partials/notification_list', ['notifications' => $notifications]);
    }

    public function arquivedComments()
    {
        $user = Auth::user();
        $notifications = Notification::getViewedNotificationsForUser($user);

        Log::info('Arquived comments accessed', ['notifications' => $notifications]);

        return view('partials/notification_list', ['notifications' => $notifications]);
    }

}
