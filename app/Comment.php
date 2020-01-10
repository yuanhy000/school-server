<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function commodity()
    {
        return $this->belongsToMany(Commodity::class, 'commodity_comments', 'comment_id', 'commodity_id');
    }

    public function article()
    {
        return $this->belongsToMany(Article::class, 'article_comments', 'comment_id', 'article_id');
    }

    public function answer()
    {
        return $this->belongsToMany(Answer::class, 'answer_comments', 'comment_id', 'answer_id');
    }

    public function activity()
    {
        return $this->belongsToMany(Activity::class, 'activity_comments', 'comment_id', 'activity_id');
    }

    public function recruit()
    {
        return $this->belongsToMany(Recruit::class, 'recruit_comments', 'comment_id', 'recruit_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function likeIncrement($comment_id)
    {
        $comment = self::find($comment_id);
        $comment->likes += 1;
        $comment->save();
    }

    public static function likeDecrement($comment_id)
    {
        $comment = self::find($comment_id);
        $comment->likes -= 1;
        $comment->save();
    }
}
