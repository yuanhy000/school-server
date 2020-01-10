<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function deleteNotification(Request $request)
    {
        $user_id = auth()->guard('api')->user()->id;
        $notification_id = $request->all()['notification_id'];

        return Notification::deleteNotification($notification_id);
    }
}
