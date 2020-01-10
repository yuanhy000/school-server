<?php

namespace App;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class LikeAnswer extends Model
{
    protected $guarded = [];

    public static function isLikeAnswer($answer_id, $user_id)
    {
        $result = self::where([
            ['user_id', '=', $user_id],
            ['answer_id', '=', $answer_id]
        ])->first();

        if ($result) {
            return $result;
        }
        return false;
    }

    public static function toggleAnswerLike($result, $answer_id, $user_id)
    {
        try {
            if ($result) {
                $result->delete();
                Answer::likeDecrement($answer_id);
            } else {
                self::create([
                    'answer_id' => $answer_id,
                    'user_id' => $user_id,
                ]);
                Answer::likeIncrement($answer_id);
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
