<?php

namespace App;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class LikeNews extends Model
{
    protected $guarded = [];

    public static function isLikeNews($news_id, $user_id)
    {
        $result = self::where([
            ['user_id', '=', $user_id],
            ['news_id', '=', $news_id]
        ])->first();

        if ($result) {
            return $result;
        }
        return false;
    }

    public static function toggleNewsLike($result, $news_id, $user_id)
    {
        try {
            if ($result) {
                $result->delete();
                News::likeDecrement($news_id);
            } else {
                self::create([
                    'news_id' => $news_id,
                    'user_id' => $user_id,
                ]);
                News::likeIncrement($news_id);
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
