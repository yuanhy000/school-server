<?php

namespace App;

use App\Exceptions\BaseException;
use App\Http\Resources\UserResource;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Exception;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function commodities()
    {
        return $this->hasMany(Commodity::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function recruit()
    {
        return $this->hasMany(Recruit::class);
    }

    public function collectArticles()
    {
        return $this->belongsToMany(Article::class, 'collect_articles', 'user_id', 'article_id');
    }

    public function collectActivities()
    {
        return $this->belongsToMany(Activity::class, 'collect_activities', 'user_id', 'activity_id');
    }

    public function collectRecruits()
    {
        return $this->belongsToMany(Recruit::class, 'collect_recruits', 'user_id', 'recruit_id');
    }

    public function collectNews()
    {
        return $this->belongsToMany(News::class, 'collect_news', 'user_id', 'news_id');
    }

    public function collectTopics()
    {
        return $this->belongsToMany(Topic::class, 'collect_topics', 'user_id', 'topic_id');
    }

    public function collectAnswers()
    {
        return $this->belongsToMany(Answer::class, 'collect_answers', 'user_id', 'answer_id');
    }

    public function collectCommodities()
    {
        return $this->belongsToMany(Commodity::class, 'collect_commodities', 'user_id', 'commodity_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_users', 'user_id', 'team_id');
    }

    public function follower()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'accept_id', 'request_id');
    }

    public function attention()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'request_id', 'accept_id');
    }

    public function findForPassport($username)
    {
        return $this->orWhere('openid', $username)->first();
    }

    public function validateForPassportPasswordGrant($password)
    {
        return true;
    }

    public static function updateUser($user_info)
    {
        $user = auth()->guard('api')->user();

        try {
            $user->name = $user_info['user_name'];
            $user->avatar = $user_info['user_avatar'];
            $user->sex = $user_info['user_sex'];
            $user->save();
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '用户信息更新失败'
            ], 408);
        }
        return $user;
    }

    public static function searchUserByNumber($user_number)
    {
        $user = self::where('number', $user_number)->first();

        if ($user) {
            return new UserResource($user);
        } else {
            throw new BaseException([
                'msg' => '没有找到用户'
            ], 404);
        }
    }

    public static function updateUserSchool($school)
    {
        $user = auth()->guard('api')->user();

        try {
            $user->school = $school;
            $user->save();
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '更改用户学校失败'
            ], 408);
        }
        return $user;
    }

    public static function attentionIncrement($user_id)
    {
        $user = self::find($user_id);
        $user->attentions += 1;
        $user->save();
    }

    public static function attentionDecrement($user_id)
    {
        $user = self::find($user_id);
        $user->attentions -= 1;
        $user->save();
    }

    public static function followerIncrement($user_id)
    {
        $user = self::find($user_id);
        $user->followers += 1;
        $user->save();
    }

    public static function followerDecrement($user_id)
    {
        $user = self::find($user_id);
        $user->followers -= 1;
        $user->save();
    }


}
