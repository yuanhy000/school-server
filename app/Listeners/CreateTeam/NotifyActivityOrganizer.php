<?php

namespace App\Listeners\CreateTeam;

use App\Events\CreateComment;
use App\Events\CreateTeam;
use App\Exceptions\BaseException;
use App\Notification;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyActivityOrganizer
{
    public function handle(CreateTeam $event)
    {
        $this->notifyActivityOrganizer($event->team, $event->team->activity->user->id, $event->manager_id);

    }

    public function notifyActivityOrganizer($team, $accept_user_id, $manager_id)
    {
        try {
            Notification::create([
                'content' => '队伍: ' . $team->name . '报名了您发布的活动',
                'request_user_id' => $manager_id,
                'accept_user_id' => $accept_user_id,
                'status' => false,
                'type' => 'activity_team'
            ]);
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '创建消息通知失败，请稍后再试'
            ], 408);
        }
    }

}
