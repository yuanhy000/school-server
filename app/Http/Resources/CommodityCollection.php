<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CommodityCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            'commodities' => CommodityResource::collection($this->collection)
        ];
    }
}
