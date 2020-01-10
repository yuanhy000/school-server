<?php

namespace App\Listeners\CreateComment;

use App\ActivityComment;
use App\ArticleComment;
use App\Events\CreateComment;
use App\Exceptions\BaseException;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class RelatedActivity
{
    public function handle(CreateComment $event)
    {
        if ($event->belong == 'activity') {
            $this->relatedActivity($event->comment->id, $event->activity_id);
        }
    }

    private function relatedActivity($comment_id, $activity_id)
    {
        DB::beginTransaction();
        try {
            ActivityComment::create([
                'activity_id' => $activity_id,
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
