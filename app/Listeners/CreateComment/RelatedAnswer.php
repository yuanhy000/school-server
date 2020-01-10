<?php

namespace App\Listeners\CreateComment;

use App\AnswerComment;
use App\Events\CreateComment;
use App\Exceptions\BaseException;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class RelatedAnswer
{
    public function handle(CreateComment $event)
    {
        if ($event->belong == 'answer') {
            $this->relatedAnswer($event->comment->id, $event->answer_id);
        }
    }

    private function relatedAnswer($comment_id, $answer_id)
    {
        DB::beginTransaction();
        try {
            AnswerComment::create([
                'answer_id' => $answer_id,
                'comment_id' => $comment_id
            ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new BaseException([
                'msg' => '回答评论关联失败'
            ], 408);
        }
    }
}
