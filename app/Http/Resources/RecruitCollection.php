<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RecruitCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            'data' => RecruitResource::collection($this->collection),
            'links' => [
                'first' => $this->url(1),
                'next' => $this->nextPageUrl(),
                'prev' => $this->previousPageUrl(),
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'path' => $this->path(),
                'per_page' => $this->perPage(),
                'to' => $this->lastItem(),
            ]
        ];
    }
}
