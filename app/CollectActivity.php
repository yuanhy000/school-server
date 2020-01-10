<?php

namespace App;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class CollectActivity extends Model
{
    protected $guarded = [];

    public static function isCollectActivity($activity_id, $user_id)
    {
        $result = self::where([
            ['user_id', '=', $user_id],
            ['activity_id', '=', $activity_id]
        ])->first();

        if ($result) {
            return $result;
        }
        return false;
    }

    public static function toggleActivityCollect($result, $activity_id, $user_id)
    {
        try {
            if ($result) {
                $result->delete();
            } else {
                self::create([
                    'activity_id' => $activity_id,
                    'user_id' => $user_id,
                ]);
            }
            return response()->json([
                'message' => '操作成功'
            ], 201);

        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '操作失败，请稍后再试'
            ], 408);
        }
    }
}
