<?php

namespace App\Listeners\CreateComment;

use App\ArticleComment;
use App\CommodityComment;
use App\Events\CreateComment;
use App\Exceptions\BaseException;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class RelatedArticle
{
    public function handle(CreateComment $event)
    {
        if ($event->belong == 'article') {
            $this->relatedArticle($event->comment->id, $event->article_id);
        }
    }

    private function relatedArticle($comment_id, $article_id)
    {
        DB::beginTransaction();
        try {
            ArticleComment::create([
                'article_id' => $article_id,
                'comment_id' => $comment_id
            ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new BaseException([
                'msg' => '商品评论关联失败'
            ], 408);
        }
    }
}
