<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'answer_comments', 'answer_id', 'comment_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'answer_images', 'answer_id', 'image_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'id');
    }

    public static function getAnswerTemperature($answer)
    {
        $G = 1.8;
        $likes = $answer->likes;

        $created_time = date_create($answer->created_at);
        $current_time = date_create(Carbon::now()->toDateTimeString());
        $days_diff = date_diff($current_time, $created_time)->days;

        return ($likes + 1) / pow(($days_diff + 2), $G);
    }

    public static function updateAnswerTemperature()
    {
        $answers = Answer::where('display', true)->get();
        foreach ($answers as $answer) {
            $answer->temperature = (new self())->getAnswerTemperature($answer);
            $answer->save();
        }
    }

    public static function likeIncrement($answer_id)
    {
        $answer = self::find($answer_id);
        $answer->likes += 1;
        $answer->save();
    }

    public static function likeDecrement($answer_id)
    {
        $answer = self::find($answer_id);
        $answer->likes -= 1;
        $answer->save();
    }

    public static function viewIncrement($answer_id)
    {
        $answer = self::find($answer_id);
        $answer->views += 1;
        $answer->save();
    }
}
