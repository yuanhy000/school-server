<?php

namespace App\Events;

use App\Comment;
use App\Commodity;
use App\Exceptions\BaseException;
use Exception;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateComment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    public $content;
    public $commodity_id;
    public $article_id;
    public $activity_id;
    public $recruit_id;
    public $answer_id;
    public $news_id;
    public $belong;
    public $parent_id;

    public function __construct($requestInfo, $belong)
    {
        $this->content = $requestInfo['comment_content'];
        $this->parent_id = $requestInfo['parent_id'];
        $this->belong = $belong;
        switch ($belong) {
            case 'commodity':
                $this->commodity_id = $requestInfo['commodity_id'];
                break;
            case 'article':
                $this->article_id = $requestInfo['article_id'];
                break;
            case 'activity':
                $this->activity_id = $requestInfo['activity_id'];
                break;
            case 'recruit':
                $this->recruit_id = $requestInfo['recruit_id'];
                break;
            case 'news':
                $this->news_id = $requestInfo['news_id'];
                break;
            case 'answer':
                $this->answer_id = $requestInfo['answer_id'];
                break;
        }
        $this->createComment();

    }

    private function createComment()
    {
        try {
            $this->comment = Comment::create([
                'content' => $this->content,
                'user_id' => auth()->guard('api')->user()->id,
                'parent_id' => $this->parent_id
            ]);
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '发布评论失败，请稍后'
            ], 408);
        }
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
