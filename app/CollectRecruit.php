<?php

namespace App;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class CollectRecruit extends Model
{
    protected $guarded = [];

    public static function isCollectRecruit($recruit_id, $user_id)
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

    public static function toggleRecruitCollect($result, $recruit_id, $user_id)
    {
        try {
            if ($result) {
                $result->delete();
            } else {
                self::create([
                    'recruit_id' => $recruit_id,
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
