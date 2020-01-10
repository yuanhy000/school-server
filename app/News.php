<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = [];

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'news_comments', 'news_id', 'comment_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'news_images', 'news_id', 'image_id');
    }

    public static function getNewsTemperature($news)
    {
        $G = 1.8;
        $likes = $news->likes;

        $created_time = date_create($news->created_at);
        $current_time = date_create(Carbon::now()->toDateTimeString());
        $days_diff = date_diff($current_time, $created_time)->days;

        return ($likes + 1) / pow(($days_diff + 2), $G);
    }

    public static function updateNewsTemperature()
    {
        $newses = News::all();
        foreach ($newses as $news) {
            $news->temperature = (new self())->getNewsTemperature($news);
            $news->save();
        }
    }

    public static function likeIncrement($news_id)
    {
        $news = self::find($news_id);
        $news->likes += 1;
        $news->save();
    }

    public static function likeDecrement($news_id)
    {
        $news = self::find($news_id);
        $news->likes -= 1;
        $news->save();
    }

    public static function viewIncrement($news_id)
    {
        $news = self::find($news_id);
        $news->views += 1;
        $news->save();
    }
}
