<?php

namespace App;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class LikeRecruit extends Model
{
    protected $guarded = [];

    public static function isLikeRecruit($recruit_id, $user_id)
    {
        $result = self::where([
            ['user_id', '=', $user_id],
            ['recruit_id', '=', $recruit_id]
        ])->first();

        if ($result) {
            return $result;
        }
        return false;
    }

    public static function toggleRecruitLike($result, $recruit_id, $user_id)
    {
        try {
            if ($result) {
                $result->delete();
                Recruit::likeDecrement($recruit_id);
            } else {
                self::create([
                    'recruit_id' => $recruit_id,
                    'user_id' => $user_id,
                ]);
                Recruit::likeIncrement($recruit_id);
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
