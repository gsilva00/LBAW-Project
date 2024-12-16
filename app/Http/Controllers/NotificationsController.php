<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationsController extends Controller
{
    public function showNotificationsPage(): View
    {
        /**
         * @var User $user
         * Return type of Auth::user() guaranteed on config/auth.php's User Providers
         */
        $user = Auth::user();
        $notifications = Notification::getNewNotificationsForUser($user);

        return view('pages/notifications_page', [
            'user' => $user,
            'notifications' => $notifications
        ]);
    }

    public function newNotifications(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $notifications = Notification::getNewNotificationsForUser($user);

        return view('partials/notification_list', [
            'notifications' => $notifications
        ]);
    }

    public function archivedNotifications(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $notifications = Notification::getArchivedNotificationsForUser($user);

        return view('partials/notification_list', [
            'notifications' => $notifications
        ]);
    }

    public function newNotificationsUpvotes(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $notifications = Notification::getNotificationsForUserByType($user, 2, false);


        return view('partials/notification_list', [
            'notifications' => $notifications
        ]);
    }

    public function newNotificationsComments(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $notifications = Notification::getNotificationsForUserByType($user, 1, false);

        return view('partials/notification_list', [
            'notifications' => $notifications
        ]);
    }

    public function archivedNotificationsUpvotes(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $notifications = Notification::getNotificationsForUserByType($user, 2, true);

        return view('partials/notification_list', [
            'notifications' => $notifications
        ]);
    }

    public function archivedNotificationsComments(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $notifications = Notification::getNotificationsForUserByType($user, 1, true);

        return view('partials/notification_list', [
            'notifications' => $notifications
        ]);
    }

    public function archivingNotification($id): JsonResponse
    {
        $notification = Notification::find($id);
        $notification->is_viewed = true;
        $notification->save();

        return response()->json([
            'success' => 'Notification archived successfully'
        ]);
    }

}
