<?php

namespace App\Listeners\CreateCommodity;

use App\CommodityImage;
use App\Events\CreateCommodity;
use App\Exceptions\BaseException;
use App\Image;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CreateCommodityImage
{

    public function handle(CreateCommodity $event)
    {
        if (!is_null($event->image_list)) {
            $this->createImage($event->commodity_id, explode(",", $event->image_list));
        }
    }

    public function createImage($commodity_id, $image_list)
    {
        DB::beginTransaction();
        try {
            foreach ($image_list as $image_url) {
                CommodityImage::create([
                    'commodity_id' => $commodity_id,
                    'image_id' => Image::create([
                        'url' => $image_url
                    ])->id
                ]);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new BaseException([
                'msg' => '商品图片关联失败'
            ], 408);
        }
    }
}
