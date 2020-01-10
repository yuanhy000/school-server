<?php

namespace App\Events;

use App\Answer;
use App\Exceptions\BaseException;
use Exception;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateAnswer
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $answer_id;
    public $topic_id;
    public $title;
    public $content;
    public $image_list;
    public $display_location;
    public $location;
    public $is_anonymity;

    public function __construct($request_info)
    {
        $this->topic_id = $request_info['topic_id'];
        $this->title = $request_info['answer_title'];
        $this->content = $request_info['answer_content'];
        $this->image_list = $request_info['answer_image'];
        $this->display_location = json_decode($request_info['is_display_location']);
        $this->is_anonymity = json_decode($request_info['is_anonymity']);
        $this->createAnswer();
    }

    private function createAnswer()
    {
        try {
            $this->answer_id = Answer::create([
                'title' => $this->title,
                'content' => $this->content,
                'topic_id' => $this->topic_id,
                'user_id' => auth()->guard('api')->user()->id,
                'display_location' => (boolean)$this->display_location,
                'anonymity' => (boolean)$this->is_anonymity
            ])->id;
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '发布回答失败，请稍后'
            ], 408);
        }
    }
}
