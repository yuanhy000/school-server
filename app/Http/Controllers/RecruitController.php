<?php

namespace App\Http\Controllers;

use App\Events\CreateReruit;
use App\Http\Resources\RecruitResource;
use App\Recruit;
use Illuminate\Http\Request;

class RecruitController extends Controller
{
    public function createRecruit(Request $request)
    {
        $requestInfo = $request->all();
        event(new CreateReruit($requestInfo));
        return response()->json([
            'message' => '发布动态成功'
        ]);
    }

    public function getRecruitDetail(Request $request)
    {
        $recruit_id = $request->all()['recruit_id'];
        $recruit = Recruit::find($recruit_id);
        Recruit::viewIncrement($recruit_id);

        return new RecruitResource($recruit, -1);
    }

}
