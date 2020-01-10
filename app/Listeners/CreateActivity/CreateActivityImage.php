<?php

namespace App\Listeners\CreateActivity;

use App\Activity;
use App\ActivityImage;
use App\ArticleImage;
use App\Events\CreateActivity;
use App\Events\CreateArticle;
use App\Exceptions\BaseException;
use App\Image;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CreateActivityImage
{
    public function handle(CreateActivity $event)
    {
        if (!is_null($event->image_list)) {
            $this->createImage($event->activity_id, explode(",", $event->image_list));
        }
    }

    public function createImage($activity_id, $image_list)
    {
        DB::beginTransaction();
        try {
            foreach ($image_list as $image_url) {
                ActivityImage::create([
                    'activity_id' => $activity_id,
                    'image_id' => Image::create([
                        'url' => $image_url
                    ])->id
                ]);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new BaseException([
                'msg' => '活动图片关联失败'
            ], 408);
        }
    }
}
