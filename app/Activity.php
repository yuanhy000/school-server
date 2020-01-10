<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'activity_comments', 'activity_id', 'comment_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'activity_images', 'activity_id', 'image_id');
    }

    public static function getActivityTemperature($activity)
    {
        $G = 1.8;
        $likes = $activity->likes;

        $created_time = date_create($activity->created_at);
        $current_time = date_create(Carbon::now()->toDateTimeString());
        $days_diff = date_diff($current_time, $created_time)->days;

        return ($likes + 1) / pow(($days_diff + 2), $G);
    }

    public static function updateActivityTemperature()
    {
        $activities = self::where('display', true)->get();
        foreach ($activities as $activity) {
            $activity->temperature = (new self())->getActivityTemperature($activity);
            $activity->save();
        }
    }

    public static function likeIncrement($activity_id)
    {
        $activity = self::find($activity_id);
        $activity->likes += 1;
        $activity->save();
    }

    public static function likeDecrement($activity_id)
    {
        $activity = self::find($activity_id);
        $activity->likes -= 1;
        $activity->save();
    }

    public static function viewIncrement($activity_id)
    {
        $activity = self::find($activity_id);
        $activity->views += 1;
        $activity->save();
    }
}
