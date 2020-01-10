<?php

namespace App\Events;

use App\Activity;
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

class  CreateActivity
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $activity_id;
    public $name;
    public $content;
    public $attention;
    public $image_list;
    public $school;
    public $organization;

    public function __construct($request_info)
    {
        $this->name = $request_info['activity_name'];
        $this->content = $request_info['activity_content'];
        $this->attention = $request_info['activity_attention'];
        $this->image_list = $request_info['activity_image'];
        $this->school = auth()->guard('api')->user()->school;
        $this->organization = auth()->guard('api')->user()->organization;
        $this->createActivity();
    }

    private function createActivity()
    {
        try {
            $this->activity_id = Activity::create([
                'name' => $this->name,
                'content' => $this->content,
                'attention' => $this->attention,
                'user_id' => auth()->guard('api')->user()->id,
                'school' => $this->school,
                'organization' => $this->organization,
            ])->id;
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '发布活动失败，请稍后'
            ], 408);
        }
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
