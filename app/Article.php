<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'article_comments', 'article_id', 'comment_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'article_images', 'article_id', 'image_id');
    }

    public static function getArticleTemperature($article)
    {
        $G = 1.8;
        $likes = $article->likes;

        $created_time = date_create($article->created_at);
        $current_time = date_create(Carbon::now()->toDateTimeString());
        $days_diff = date_diff($current_time, $created_time)->days;

        return ($likes + 1) / pow(($days_diff + 2), $G);
    }

    public static function updateArticleTemperature()
    {
        $articles = Article::where('display', true)->get();
        foreach ($articles as $article) {
            $article->temperature = (new self())->getArticleTemperature($article);
            $article->save();
        }
    }

    public static function likeIncrement($article_id)
    {
        $article = self::find($article_id);
        $article->likes += 1;
        $article->save();
    }

    public static function likeDecrement($article_id)
    {
        $article = self::find($article_id);
        $article->likes -= 1;
        $article->save();
    }

    public static function viewIncrement($article_id)
    {
        $article = self::find($article_id);
        $article->views += 1;
        $article->save();
    }
}
