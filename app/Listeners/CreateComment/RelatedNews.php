<?php

namespace App\Listeners\CreateComment;

use App\NewsComment;
use App\Events\CreateComment;
use App\Exceptions\BaseException;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class RelatedNews
{
    public function handle(CreateComment $event)
    {
        if ($event->belong == 'news') {
            $this->relatedNews($event->comment->id, $event->news_id);
        }
    }

    private function relatedNews($comment_id, $news_id)
    {
        DB::beginTransaction();
        try {
            NewsComment::create([
                'news_id' => $news_id,
                'comment_id' => $comment_id
            ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new BaseException([
                'msg' => '新闻评论关联失败'
            ], 408);
        }
    }
}
