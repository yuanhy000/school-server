<?php

namespace App\Http\Controllers;

use App\LikeActivity;
use App\LikeAnswer;
use App\LikeArticle;
use App\LikeComment;
use App\LikeCommodity;
use App\LikeNews;
use App\LikeRecruit;
use App\LikeTopic;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggleArticleLike(Request $request)
    {
        $article_id = $request->all()['article_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = LikeArticle::isLikeArticle($article_id, $user_id);

        return LikeArticle::toggleArticleLike($result, $article_id, $user_id);
    }

    public function toggleActivityLike(Request $request)
    {
        $activity_id = $request->all()['activity_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = LikeActivity::isLikeActivity($activity_id, $user_id);

        return LikeActivity::toggleActivityLike($result, $activity_id, $user_id);
    }

    public function toggleRecruitLike(Request $request)
    {
        $recruit_id = $request->all()['recruit_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = LikeRecruit::isLikeRecruit($recruit_id, $user_id);

        return LikeRecruit::toggleRecruitLike($result, $recruit_id, $user_id);
    }

    public function toggleCommodityLike(Request $request)
    {
        $commodity_id = $request->all()['commodity_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = LikeCommodity::isLikeCommodity($commodity_id, $user_id);

        return LikeCommodity::toggleCommodityLike($result, $commodity_id, $user_id);
    }

    public function toggleCommentLike(Request $request)
    {
        $comment_id = $request->all()['comment_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = LikeComment::isLikeComment($comment_id, $user_id);

        return LikeComment::toggleCommentLike($result, $comment_id, $user_id);
    }

    public function toggleNewsLike(Request $request)
    {
        $news_id = $request->all()['news_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = LikeNews::isLikeNews($news_id, $user_id);

        return LikeNews::toggleNewsLike($result, $news_id, $user_id);
    }


    public function toggleTopicLike(Request $request)
    {
        $topic_id = $request->all()['topic_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = LikeTopic::isLikeTopic($topic_id, $user_id);

        return LikeTopic::toggleTopicLike($result, $topic_id, $user_id);
    }


    public function toggleAnswerLike(Request $request)
    {
        $answer_id = $request->all()['answer_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = LikeAnswer::isLikeAnswer($answer_id, $user_id);

        return LikeAnswer::toggleAnswerLike($result, $answer_id, $user_id);
    }


}
