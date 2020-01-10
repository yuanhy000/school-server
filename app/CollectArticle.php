<?php

namespace App;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class CollectArticle extends Model
{
    protected $guarded = [];

    public static function isCollectArticle($article_id, $user_id)
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

    public static function toggleArticleCollect($result, $article_id, $user_id)
    {
        try {
            if ($result) {
                $result->delete();
            } else {
                self::create([
                    'article_id' => $article_id,
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
