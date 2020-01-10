<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'topic_images', 'topic_id', 'image_id');
    }

    public static function getTopicTemperature($topic)
    {
        $G = 1.8;
        $likes = $topic->likes;
        $answer = $topic->answer_count;

        $created_time = date_create($topic->created_at);
        $current_time = date_create(Carbon::now()->toDateTimeString());
        $days_diff = date_diff($current_time, $created_time)->days;

        return ($likes + 1 + 5 * $answer) / pow(($days_diff + 2), $G);
    }

    public static function updateTopicTemperature()
    {
        $topics = Topic::where('display', true)->get();
        foreach ($topics as $topic) {
            $topic->temperature = (new self())->getTopicTemperature($topic);
            $topic->save();
        }
    }

    public static function likeIncrement($topic_id)
    {
        $topic = self::find($topic_id);
        $topic->likes += 1;
        $topic->save();
    }

    public static function likeDecrement($topic_id)
    {
        $topic = self::find($topic_id);
        $topic->likes -= 1;
        $topic->save();
    }

    public static function viewIncrement($topic_id)
    {
        $topic = self::find($topic_id);
        $topic->views += 1;
        $topic->save();
    }
}
