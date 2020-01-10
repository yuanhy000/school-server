<?php

namespace App\Listeners\CreateArticle;

use App\ArticleImage;
use App\Events\CreateArticle;
use App\Exceptions\BaseException;
use App\Image;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Exception;

class CreateArticleImage
{

    public function handle(CreateArticle $event)
    {
        if (!is_null($event->image_list)) {
            $this->createImage($event->article_id, explode(",",$event->image_list));
        }
    }

    public function createImage($article_id, $image_list)
    {
        DB::beginTransaction();
        try {
            foreach ($image_list as $image_url) {
                ArticleImage::create([
                    'article_id' => $article_id,
                    'image_id' => Image::create([
                        'url' => $image_url
                    ])->id
                ]);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new BaseException([
                'msg' => '动态图片关联失败'
            ], 408);
        }
    }
}
