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
        $notifications = Notification::getNewNotificationsForUser($user);

        return view('pages/notifications_page', ['user' => $user, 'notifications' => $notifications]);
    }

    public function newNotifications()
    {
        $user = Auth::user();
        $notifications = Notification::getNewNotificationsForUser($user);

        return view('partials/notification_list', ['notifications' => $notifications]);
    }

    public function arquivedNotifications()
    {
        $user = Auth::user();
        $notifications = Notification::getArquivedNotificationsForUser($user);

        return view('partials/notification_list', ['notifications' => $notifications]);
    }

    public function newNotificationsUpvotes()
    {
        $user = Auth::user();
        $notifications = Notification::getNotificationsForUserByType($user, 2, false);


        return view('partials/notification_list', ['notifications' => $notifications]);
    }

    public function newNotificationsComments()
    {
        $user = Auth::user();
        $notifications = Notification::getNotificationsForUserByType($user, 1, false);

        return view('partials/notification_list', ['notifications' => $notifications]);
    }

    public function arquivedNotificationsUpvotes()
    {
        $user = Auth::user();
        $notifications = Notification::getNotificationsForUserByType($user, 2, true);

        return view('partials/notification_list', ['notifications' => $notifications]);
    }

    public function arquivedNotificationsComments()
    {
        $user = Auth::user();
        $notifications = Notification::getNotificationsForUserByType($user, 1, true);

        return view('partials/notification_list', ['notifications' => $notifications]);
    }

    public function archivingNotification($id)
    {
        $notification = Notification::find($id);
        $notification->is_viewed = true;
        $notification->save();

        return response()->json(['success' => 'Notification archived successfully']);
    }

}
