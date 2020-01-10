<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Events\CreateActivity;
use App\Events\CreateTeam;
use App\Http\Resources\ActivityResource;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

    public function createActivity(Request $request)
    {
        $requestInfo = $request->all();
        event(new CreateActivity($requestInfo));
        return response()->json([
            'message' => '发布活动成功'
        ]);
    }

    public function getActivityDetail(Request $request)
    {
        $article_id = $request->all()['activity_id'];
        $article = Activity::find($article_id);
        Activity::viewIncrement($article_id);

        return new ActivityResource($article, -1);
    }

    public function createActivityTeam(Request $request)
    {
        $requestInfo = $request->all();
        event(new CreateTeam($requestInfo));

        return response()->json([
            'message' => '活动报名成功'
        ]);
    }
}
