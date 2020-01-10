<?php

namespace App\Listeners\CreateRecruit;

use App\Events\CreateReruit;
use App\Exceptions\BaseException;
use App\Image;
use App\RecruitImage;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CreateRecruitImage
{
    public function handle(CreateReruit $event)
    {
        if (!is_null($event->image_list)) {
            $this->createImage($event->recruit_id, explode(",", $event->image_list));
        }
    }

    public function createImage($recruit_id, $image_list)
    {
        DB::beginTransaction();
        try {
            if ($image_list) {
                foreach ($image_list as $image_url) {
                    RecruitImage::create([
                        'recruit_id' => $recruit_id,
                        'image_id' => Image::create([
                            'url' => $image_url
                        ])->id
                    ]);
                }
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new BaseException([
                'msg' => '招募图片关联失败'
            ], 408);
        }
    }
}
