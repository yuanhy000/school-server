<?php

namespace App;

use App\Exceptions\BaseException;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];

    public static function deleteNotification($notification_id)
    {
        try {
            $notification = Notification::find($notification_id);
            $notification->operation = 0;
            $notification->save();
            return response()->json([
                'msg' => '删除成功'
            ], 200);
        } catch (\Exception $exception) {
            throw new BaseException([
                'msg' => '消息删除失败'
            ], 408);
        }
    }

}
