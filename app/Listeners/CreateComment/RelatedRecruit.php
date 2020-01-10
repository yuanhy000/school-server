<?php

namespace App\Listeners\CreateComment;

use App\ArticleComment;
use App\Events\CreateComment;
use App\Exceptions\BaseException;
use App\RecruitComment;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class RelatedRecruit
{
    public function handle(CreateComment $event)
    {
        if ($event->belong == 'recruit') {
            $this->relatedArticle($event->comment->id, $event->recruit_id);
        }
    }

    private function relatedArticle($comment_id, $recruit_id)
    {
        DB::beginTransaction();
        try {
            RecruitComment::create([
                'recruit_id' => $recruit_id,
                'comment_id' => $comment_id
            ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new BaseException([
                'msg' => '招募评论关联失败'
            ], 408);
        }
    }
}
