<?php

namespace App\Listeners\CreateTopic;

use App\ArticleImage;
use App\Events\CreateArticle;
use App\Events\CreateTopic;
use App\Exceptions\BaseException;
use App\Image;
use App\TopicImage;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CreateTopicImage
{
    public function handle(CreateTopic $event)
    {
        if (!is_null($event->image_list)) {
            $this->createImage($event->topic_id, explode(",", $event->image_list));
        }
    }

    public function createImage($topic_id, $image_list)
    {
        DB::beginTransaction();
        try {
            foreach ($image_list as $image_url) {
                TopicImage::create([
                    'topic_id' => $topic_id,
                    'image_id' => Image::create([
                        'url' => $image_url
                    ])->id
                ]);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new BaseException([
                'msg' => '话题图片关联失败'
            ], 408);
        }
    }
}
