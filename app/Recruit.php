<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Recruit extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'recruit_comments', 'recruit_id', 'comment_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'recruit_images', 'recruit_id', 'image_id');
    }

    public static function getRecruitTemperature($recruit)
    {
        $G = 1.8;
        $likes = $recruit->likes;

        $created_time = date_create($recruit->created_at);
        $current_time = date_create(Carbon::now()->toDateTimeString());
        $days_diff = date_diff($current_time, $created_time)->days;

        return ($likes + 1) / pow(($days_diff + 2), $G);
    }

    public static function updateRecruitTemperature()
    {
        $recruits = self::where('display', true)->get();
        foreach ($recruits as $recruit) {
            $recruit->temperature = (new self())->getRecruitTemperature($recruit);
            $recruit->save();
        }
    }

    public static function likeIncrement($recruit_id)
    {
        $recruit = self::find($recruit_id);
        $recruit->likes += 1;
        $recruit->save();
    }

    public static function likeDecrement($recruit_id)
    {
        $recruit = self::find($recruit_id);
        $recruit->likes -= 1;
        $recruit->save();
    }

    public static function viewIncrement($recruit_id)
    {
        $recruit = self::find($recruit_id);
        $recruit->views += 1;
        $recruit->save();
    }
}
