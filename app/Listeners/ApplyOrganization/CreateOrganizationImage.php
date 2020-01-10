<?php

namespace App\Listeners\ApplyOrganization;

use App\ArticleImage;
use App\Events\ApplyOrganization;
use App\Events\CreateArticle;
use App\Exceptions\BaseException;
use App\Image;
use App\OrganizationImage;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CreateOrganizationImage
{
    public function handle(ApplyOrganization $event)
    {
        if (!is_null($event->image_list)) {
            $this->createImage($event->organization_id, explode(",", $event->image_list));
        }
    }

    public function createImage($organization_id, $image_list)
    {
        DB::beginTransaction();
        try {
            foreach ($image_list as $image_url) {
                OrganizationImage::create([
                    'organization_id' => $organization_id,
                    'image_id' => Image::create([
                        'url' => $image_url
                    ])->id
                ]);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new BaseException([
                'msg' => '认证图片关联失败'
            ], 408);
        }
    }
}
