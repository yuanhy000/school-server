<?php

namespace App;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class LikeTopic extends Model
{
    protected $guarded = [];

    public static function isLikeTopic($topic_id, $user_id)
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

    public static function toggleTopicLike($result, $topic_id, $user_id)
    {
        try {
            if ($result) {
                $result->delete();
                Topic::likeDecrement($topic_id);
            } else {
                self::create([
                    'topic_id' => $topic_id,
                    'user_id' => $user_id,
                ]);
                Topic::likeIncrement($topic_id);
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
