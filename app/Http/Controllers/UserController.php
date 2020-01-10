<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Article;
use App\Events\ApplyOrganization;
use App\Events\CreateArticle;
use App\Exceptions\BaseException;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\LikeInformationResource;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\TeamResource;
use App\Notification;
use App\Topic;
use App\User;
use App\UserFollow;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        try {
            $user = auth()->guard('api')->user();
        } catch (\Exception $exception) {
            throw new BaseException([
                'msg' => 'Token 无效'
            ], 404);
        }
//        $user = $request->user();
        return new UserResource($user, -1);
    }

    public function updateUserInfo(Request $request)
    {
        $userInfo = $request->all();
        return new UserResource(User::updateUser($userInfo), -1);
    }

    public function setUserSchool(Request $request)
    {
        $school = $request->all()['school'];
        return new UserResource(User::updateUserSchool($school));
    }

    public function applyOrganization(Request $request)
    {
        $requestInfo = $request->all();
        event(new ApplyOrganization($requestInfo));
        return response()->json([
            'message' => '申请成功'
        ]);
    }

    public function toggleUserFollow(Request $request)
    {
        $accept_id = $request->all()['accept_id'];
        $request_id = auth()->guard('api')->user()->id;

        $result = UserFollow::isFollowUser($accept_id, $request_id);

        return UserFollow::toggleUserFollow($result, $accept_id, $request_id);
    }

    public function searchByNumber(Request $request)
    {
        $user_number = (int)$request->all()['user_number'];

        return User::searchUserByNumber($user_number);
    }

    public function getUserCollectInfo(Request $request)
    {
        $user_id = $request->all()['user_id'];
        $user = User::find($user_id);

        $articles = $user->collectArticles->sortByDesc('created_at');
        $activities = $user->collectActivities->sortByDesc('created_at');
        $recruits = $user->collectRecruits->sortByDesc('created_at');
        $news = $user->collectNews->sortByDesc('created_at');
        $commodities = $user->collectCommodities->sortByDesc('created_at');
        $topics = $user->collectTopics->sortByDesc('created_at');
        $answers = $user->collectAnswers->sortByDesc('created_at');
        return new LikeInformationResource($articles, $articles, $activities, $recruits, $commodities, $news, -1, $topics, $answers);
    }

    public function getUserActivity(Request $request)
    {
        $user_id = $request->all()['user_id'];
        $user = User::find($user_id);

        $teams = $user->teams;
        return TeamResource::collection($teams);
    }

    public function getUserNotification(Request $request)
    {
        $user_id = $request->all()['user_id'];

        $notificationCollect = Notification::where('accept_user_id', '=', $user_id);
        $notificationCollect->update([
            'status' => 1
        ]);

        $notifications = $notificationCollect->where('operation', '!=', 0)
            ->orderBy('created_at', 'desc')->paginate(20);
        return NotificationResource::collection($notifications);
    }

    public function getUserShowInfo(Request $request)
    {
        $user_id = $request->all()['user_id'];

        $user = User::find($user_id);

        return new UserResource($user, 0, -1);
    }

    public function getUserHistory(Request $request)
    {
        $user_id = $request->all()['user_id'];
        $user = User::find($user_id);

        $articles = Article::where('user_id', $user_id)->where('anonymity', 0)->get()->sortByDesc('created_at');
        $activities = $user->activities->sortByDesc('created_at');
        $recruits = $user->recruit->sortByDesc('created_at');
        $commodities = $user->commodities->sortByDesc('created_at');
        $topics = Topic::where('user_id', $user_id)->where('anonymity', 0)->get()->sortByDesc('created_at');
        $answers = Answer::where('user_id', $user_id)->where('anonymity', 0)->get()->sortByDesc('created_at');
        return new LikeInformationResource($articles, $articles, $activities, $recruits, $commodities, 0, 0, $topics, $answers);
    }

    public function getUserFollower(Request $request)
    {
        $user_id = $request->all()['user_id'];
        $user = User::find($user_id);

        $followers = $user->follower->sortByDesc('created_at');;
        return UserResource::collection($followers);
    }

    public function getUserAttention(Request $request)
    {
        $user_id = $request->all()['user_id'];
        $user = User::find($user_id);

        $followers = $user->attention->sortByDesc('created_at');;
        return UserResource::collection($followers);
    }
}
