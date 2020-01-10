<?php

namespace App\Listeners\CreateAnswer;

use App\AnswerImage;
use App\Events\CreateAnswer;
use App\Exceptions\BaseException;
use App\Image;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CreateAnswerImage
{
    public function handle(CreateAnswer $event)
    {
        if (!is_null($event->image_list)) {
            $this->createImage($event->answer_id, explode(",", $event->image_list));
        }
    }

    public function createImage($answer_id, $image_list)
    {
        DB::beginTransaction();
        try {
            foreach ($image_list as $image_url) {
                AnswerImage::create([
                    'answer_id' => $answer_id,
                    'image_id' => Image::create([
                        'url' => $image_url
                    ])->id
                ]);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new BaseException([
                'msg' => '回答图片关联失败'
            ], 408);
        }
    }
}
