<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Article;
use App\Http\Resources\ActivityCollection;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\InformationResource;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\News;
use App\Recruit;
use App\User;
use App\UserFollow;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function getRecommendInformation(Request $request)
    {
        $articles = Article::where('display', true)->orderBy('temperature', 'desc')
            ->orderBy('created_at', 'desc')->paginate(10);
        $activities = Activity::where('display', true)->orderBy('temperature', 'desc')
            ->orderBy('created_at', 'desc')->paginate(10);
        $recruits = Recruit::where('display', true)->orderBy('temperature', 'desc')
            ->orderBy('created_at', 'desc')->paginate(10);
        $news = News::orderBy('created_at', 'desc')->paginate(5);

        $request_id = auth()->guard('api')->user()->id;
        $followUser = UserFollow::where('request_id', $request_id)->get();
        $followUserID = [];
        for ($i = 0; $i < count($followUser); $i++) {
            $followUserID[$i] = $followUser[$i]->accept_id;
        }
        $attentions = Article::whereIn('user_id', $followUserID)->where('anonymity', false)
            ->orderBy('created_at', 'desc')->paginate(10);

        return new InformationResource($articles,$articles, $activities, $recruits, $attentions, $news);
    }


    public function getNewsDetail(Request $request)
    {
        $news_id = $request->all()['news_id'];
        $news = News::find($news_id);
        News::viewIncrement($news_id);

        return new NewsResource($news, -1);
    }
}
