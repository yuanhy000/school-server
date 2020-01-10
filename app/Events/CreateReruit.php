<?php

namespace App\Events;

use App\recruit;
use App\Exceptions\BaseException;
use Exception;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateReruit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recruit_id;
    public $title;
    public $content;
    public $target;
    public $image_list;
    public $display_location;
    public $location;

    public function __construct($request_info)
    {
        $this->title = $request_info['recruit_title'];
        $this->content = $request_info['recruit_content'];
        $this->target = $request_info['recruit_target'];
        $this->image_list = $request_info['recruit_image'];
        $this->display_location = json_decode($request_info['is_display_location']);
        $this->location = $request_info['location'];
        $this->createRecruit();
    }

    private function createRecruit()
    {
        try {
            $this->recruit_id = Recruit::create([
                'title' => $this->title,
                'content' => $this->content,
                'target' => $this->target,
                'user_id' => auth()->guard('api')->user()->id,
                'display_location' => (boolean)$this->display_location,
                'location' => $this->location,
            ])->id;
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '发布招募失败，请稍后'
            ], 408);
        }
    }
}
