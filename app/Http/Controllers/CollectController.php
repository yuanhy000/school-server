<?php

namespace App\Http\Controllers;

use App\CollectActivity;
use App\CollectAnswer;
use App\CollectArticle;
use App\CollectCommodity;
use App\CollectNews;
use App\CollectRecruit;
use App\CollectTopic;
use App\LikeCommodity;
use Illuminate\Http\Request;

class CollectController extends Controller
{
    public function toggleCommodityCollect(Request $request)
    {
        $commodity_id = $request->all()['commodity_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = CollectCommodity::isCollectCommodity($commodity_id, $user_id);

        return CollectCommodity::toggleCommodityCollect($result, $commodity_id, $user_id);
    }

    public function toggleArticleCollect(Request $request)
    {
        $article_id = $request->all()['article_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = CollectArticle::isCollectArticle($article_id, $user_id);

        return CollectArticle::toggleArticleCollect($result, $article_id, $user_id);
    }

    public function toggleActivityCollect(Request $request)
    {
        $activity_id = $request->all()['activity_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = CollectActivity::isCollectActivity($activity_id, $user_id);

        return CollectActivity::toggleActivityCollect($result, $activity_id, $user_id);
    }

    public function toggleRecruitCollect(Request $request)
    {
        $recruit_id = $request->all()['recruit_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = CollectRecruit::isCollectRecruit($recruit_id, $user_id);

        return CollectRecruit::toggleRecruitCollect($result, $recruit_id, $user_id);
    }

    public function toggleNewsCollect(Request $request)
    {
        $news_id = $request->all()['news_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = CollectNews::isCollectNews($news_id, $user_id);

        return CollectNews::toggleNewsCollect($result, $news_id, $user_id);
    }

    public function toggleTopicCollect(Request $request)
    {
        $topic_id = $request->all()['topic_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = CollectTopic::isCollectTopic($topic_id, $user_id);

        return CollectTopic::toggleTopicCollect($result, $topic_id, $user_id);
    }


    public function toggleAnswerCollect(Request $request)
    {
        $answer_id = $request->all()['answer_id'];
        $user_id = auth()->guard('api')->user()->id;

        $result = CollectAnswer::isCollectAnswer($answer_id, $user_id);

        return CollectAnswer::toggleAnswerCollect($result, $answer_id, $user_id);
    }
}
