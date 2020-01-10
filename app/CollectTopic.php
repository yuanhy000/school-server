<?php

namespace App;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class CollectTopic extends Model
{
    protected $guarded = [];

    public static function isCollectTopic($topic_id, $user_id)
    {
        $result = self::where([
            ['user_id', '=', $user_id],
            ['topic_id', '=', $topic_id]
        ])->first();

        if ($result) {
            return $result;
        }
        return false;
    }

    public static function toggleTopicCollect($result, $topic_id, $user_id)
    {
        try {
            if ($result) {
                $result->delete();
            } else {
                self::create([
                    'topic_id' => $topic_id,
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
