<?php

namespace App\Http\Controllers;

use App\Events\CreateComment;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function createCommodityComment(Request $request)
    {
        $requestInfo = $request->all();
        event($event = new CreateComment($requestInfo, 'commodity'));

        return new CommentResource($event->comment);
    }

    public function createArticleComment(Request $request)
    {
        $requestInfo = $request->all();
        event($event = new CreateComment($requestInfo, 'article'));

        return new CommentResource($event->comment);
    }

    public function createActivityComment(Request $request)
    {
        $requestInfo = $request->all();
        event($event = new CreateComment($requestInfo, 'activity'));

        return new CommentResource($event->comment);
    }

    public function createRecruitComment(Request $request)
    {
        $requestInfo = $request->all();
        event($event = new CreateComment($requestInfo, 'recruit'));

        return new CommentResource($event->comment);
    }

    public function createNewsComment(Request $request)
    {
        $requestInfo = $request->all();
        event($event = new CreateComment($requestInfo, 'news'));

        return new CommentResource($event->comment);
    }

    public function createAnswerComment(Request $request)
    {
        $requestInfo = $request->all();
        event($event = new CreateComment($requestInfo, 'answer'));

        return new CommentResource($event->comment);
    }
}
