<?php

namespace App;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class LikeCommodity extends Model
{
    protected $guarded = [];

    public static function isLikeCommodity($commodity_id, $user_id)
    {
        $result = self::where([
            ['user_id', '=', $user_id],
            ['commodity_id', '=', $commodity_id]
        ])->first();

        if ($result) {
            return $result;
        }
        return false;
    }

    public static function toggleCommodityLike($result, $commodity_id, $user_id)
    {
        try {
            if ($result) {
                $result->delete();
                Commodity::likeDecrement($commodity_id);
            } else {
                self::create([
                    'commodity_id' => $commodity_id,
                    'user_id' => $user_id,
                ]);
                Commodity::likeIncrement($commodity_id);
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
