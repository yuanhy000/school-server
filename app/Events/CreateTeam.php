<?php

namespace App\Events;

use App\Comment;
use App\Exceptions\BaseException;
use App\Team;
use Exception;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateTeam
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $team;
    public $activity_id;
    public $name;
    public $user_list;
    public $manager_id;

    public function __construct($requestInfo)
    {
        $this->activity_id = $requestInfo['activity_id'];
        $this->name = $requestInfo['team_name'];
        $this->manager_id = auth()->guard('api')->user()->id;
        $this->user_list = $requestInfo['team_user'];
        $this->createTeam();
    }

    private function createTeam()
    {
        try {
            $this->team = Team::create([
                'name' => $this->name,
                'activity_id' => $this->activity_id,
                'manager_id' => $this->manager_id
            ]);
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '创建队伍失败，请稍后'
            ], 408);
        }
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
