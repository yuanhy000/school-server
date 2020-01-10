<?php

namespace App\Listeners\CreateComment;

use App\CommodityComment;
use App\Events\CreateComment;
use App\Exceptions\BaseException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Exception;
use Illuminate\Support\Facades\DB;

class RelatedCommodity
{

    public function handle(CreateComment $event)
    {
        if ($event->belong == 'commodity') {
            $this->relatedCommodity($event->comment->id, $event->commodity_id);
        }
    }

    private function relatedCommodity($comment_id, $commodity_id)
    {
        DB::beginTransaction();
        try {
            CommodityComment::create([
                'commodity_id' => $commodity_id,
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
