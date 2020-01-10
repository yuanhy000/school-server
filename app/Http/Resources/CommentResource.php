<?php

namespace App\Http\Resources;

use App\LikeComment;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'comment_id' => $this->id,
            'comment_content' => $this->content,
            'comment_parent_id' => $this->parent_id,
            'comment_likes' => $this->likes,
            'comment_user' => new UserResource($this->user),
            'comment_created' => $this->created_at->format('Y-m-d H:i'),
            'comment_like' =>
                (boolean)LikeComment::isLikeComment($this->id, auth()->guard('api')->user()->id)
        ];
    }
}
