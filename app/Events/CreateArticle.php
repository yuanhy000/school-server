<?php

namespace App\Events;

use App\Article;
use App\Exceptions\BaseException;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Exception;

class CreateArticle
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $article_id;
    public $title;
    public $content;
    public $image_list;
    public $display_location;
    public $location;
    public $is_anonymity;

    public function __construct($request_info)
    {
        $this->title = $request_info['article_title'];
        $this->content = $request_info['article_content'];
        $this->image_list = $request_info['article_image'];
        $this->display_location = json_decode($request_info['is_display_location']);
        $this->location = $request_info['location'];
        $this->is_anonymity = json_decode($request_info['is_anonymity']);
        $this->createArticle();
    }

    private function createArticle()
    {
        try {
            $this->article_id = Article::create([
                'title' => $this->title,
                'content' => $this->content,
                'user_id' => auth()->guard('api')->user()->id,
                'display_location' => (boolean)$this->display_location,
                'anonymity' => (boolean)$this->is_anonymity,
                'location' => $this->location,
            ])->id;
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '发表动态失败，请稍后'
            ], 408);
        }
    }

}
