<?php

namespace App;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class LikeComment extends Model
{
    protected $guarded = [];

    public static function isLikeComment($comment_id, $user_id)
    {
        $result = self::where([
            ['user_id', '=', $user_id],
            ['comment_id', '=', $comment_id]
        ])->first();

        if ($result) {
            return $result;
        }
        return false;
    }


    public static function toggleCommentLike($result, $comment_id, $user_id)
    {
        try {
            if ($result) {
                $result->delete();
                Comment::likeDecrement($comment_id);
            } else {
                self::create([
                    'comment_id' => $comment_id,
                    'user_id' => $user_id,
                ]);
                Comment::likeIncrement($comment_id);
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
