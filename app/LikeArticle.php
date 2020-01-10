<?php

namespace App;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class LikeArticle extends Model
{
    protected $guarded = [];

    public static function isLikeArticle($article_id, $user_id)
    {
        $result = self::where([
            ['user_id', '=', $user_id],
            ['article_id', '=', $article_id]
        ])->first();

        if ($result) {
            return $result;
        }
        return false;
    }

    public static function toggleArticleLike($result, $article_id, $user_id)
    {
        try {
            if ($result) {
                $result->delete();
                Article::likeDecrement($article_id);
            } else {
                self::create([
                    'article_id' => $article_id,
                    'user_id' => $user_id,
                ]);
                Article::likeIncrement($article_id);
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
