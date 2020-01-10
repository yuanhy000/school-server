<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'commodity_comments', 'commodity_id', 'comment_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'commodity_images', 'commodity_id', 'image_id');
    }

    public static function updateCommodityTemperature()
    {
        $commodities = Commodity::where('display', true)->get();
        foreach ($commodities as $commodity) {
            $commodity->temperature = (new self())->getCommodityTemperature($commodity);
            $commodity->save();
        }
    }

    public static function getCommodityTemperature($commodity)
    {
        $G = 1.8;
        $likes = $commodity->likes;

        $created_time = date_create($commodity->created_at);
        $current_time = date_create(Carbon::now()->toDateTimeString());
        $days_diff = date_diff($current_time, $created_time)->days;

        return ($likes + 1) / pow(($days_diff + 2), $G);
    }

    public static function searchCommodity($keyword)
    {
        return self::where('display', true)
            ->where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->orderBy('temperature', 'desc')
            ->paginate(20);
    }

    public static function likeIncrement($commodity_id)
    {
        $commodity = self::find($commodity_id);
        $commodity->likes += 1;
        $commodity->save();
    }

    public static function likeDecrement($commodity_id)
    {
        $commodity = self::find($commodity_id);
        $commodity->likes -= 1;
        $commodity->save();
    }

    public static function viewIncrement($commodity_id)
    {
        $commodity = self::find($commodity_id);
        $commodity->views += 1;
        $commodity->save();
    }
}
