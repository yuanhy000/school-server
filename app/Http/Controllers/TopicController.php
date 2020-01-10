<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Events\CreateAnswer;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\TopicResource;
use App\Topic;
use App\Events\CreateTopic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function createTopic(Request $request)
    {
        $requestInfo = $request->all();

        event(new CreateTopic($requestInfo));
        return response()->json([
            'message' => '发布话题成功'
        ]);
    }

    public function getRecommendTopic(Request $request)
    {
        $topics = Topic::where('display', true)->orderBy('temperature', 'desc')
            ->orderBy('created_at', 'desc')->paginate(10);

        return TopicResource::collection($topics);
    }

    public function getDetailTopic(Request $request)
    {
        $topic_id = $request->all()['topic_id'];
        $topic = Topic::find($topic_id);
        Topic::viewIncrement($topic_id);

        return new TopicResource($topic, -1);
    }


    public function getTopicAnswers(Request $request)
    {
        $topic_id = $request->all()['topic_id'];

        $answers = Answer::where('display', true)->where('topic_id', $topic_id)->paginate(10);

        return AnswerResource::collection($answers);
    }

    public function createAnswer(Request $request)
    {
        $requestInfo = $request->all();

        event(new CreateAnswer($requestInfo));
        return response()->json([
            'message' => '发布回答成功'
        ]);
    }

    public function getRecommendAnswers(Request $request)
    {
        $answers = Answer::where('display', true)->orderBy('temperature', 'desc')
            ->orderBy('created_at', 'desc')->paginate(10);

        return AnswerResource::collection($answers);
    }

    public function getDetailAnswer(Request $request)
    {
        $answer_id = $request->all()['answer_id'];
        $answer = Answer::find($answer_id);
        Answer::viewIncrement($answer_id);

        return new AnswerResource($answer, -1);
    }
}
