<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    /**
     * UserNotificationController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Auth::user()->unreadNotifications;
    }

    /**
     * @param User $user
     * @param $notificationId
     *
     * @throws \Exception
     */
    public function destroy(User $user, $notificationId)
    {
        $user->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
