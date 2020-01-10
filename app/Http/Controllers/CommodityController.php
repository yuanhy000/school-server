<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\Events\CreateCommodity;
use App\Exceptions\BaseException;
use App\Http\Resources\CommodityCollection;
use App\Http\Resources\CommodityResource;
use Illuminate\Http\Request;

class CommodityController extends Controller
{
    public function createCommodity(Request $request)
    {
        $requestInfo = $request->all();
        event(new CreateCommodity($requestInfo));
        return response()->json([
            'message' => '发布动态成功'
        ]);
    }

    public function getRecommendCommodity(Request $request)
    {
        $commodities = Commodity::where('display', true)->orderBy('temperature', 'desc')->paginate(20);

        return CommodityResource::collection($commodities);
    }

    public static function getSimilarRecommendCommodity($commodity_id, $category_id)
    {
        $commodities = Commodity::where([
            ['display', '=', true],
            ['id', '!=', $commodity_id],
            ['category_id', '=', $category_id]
        ])->orderBy('temperature', 'desc')->paginate(8);

        return CommodityResource::collection($commodities);
    }

    public function getCategoryCommodity(Request $request)
    {
        $commodities = Commodity::where([
            ['display', true],
            ['category_id', $request->all()['category_id']]
        ])->orderBy('temperature', 'desc')->paginate(20);

        if ($commodities->count() != 0) {
            return CommodityResource::collection($commodities);
        }
        throw new BaseException([
            'msg' => '没有找到相关物品'
        ], 404);
    }

    public function getCommodityDetail(Request $request)
    {
        $commodity_id = $request->all()['commodity_id'];
        $commodity = Commodity::find($commodity_id);
        Commodity::viewIncrement($commodity_id);

        return new CommodityResource($commodity, -1);
    }

    public function searchCommodity(Request $request)
    {
        $keyword = $request->all()['search_keyword'];
        $commodities = Commodity::searchCommodity($keyword);

        if ($commodities->count() != 0) {
            return CommodityResource::collection($commodities);
        }
        throw new BaseException([
            'msg' => '没有找到相关物品'
        ], 404);
    }
}
