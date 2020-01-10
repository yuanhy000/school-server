<?php

namespace App\Listeners\CreateComment;

use App\Commodity;
use App\Events\CreateComment;
use App\Notification;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Exception;
use App\Exceptions\BaseException;

class NotifyReceiver
{
    public function handle(CreateComment $event)
    {
        if ($event->belong == 'commodity') {
            $this->notifyCommodityReceiver(auth()->guard('api')->user(),
                $event->comment->commodity->first()->user_id, $event->commodity_id);
        } else if ($event->belong == 'article') {
            $this->notifyArticleReceiver(auth()->guard('api')->user(),
                $event->comment->article->first()->user_id, $event->article_id);
        } else if ($event->belong == 'activity') {
            $this->notifyActivityReceiver(auth()->guard('api')->user(),
                $event->comment->activity->first()->user_id, $event->activity_id);
        } else if ($event->belong == 'recruit') {
            $this->notifyRecruitReceiver(auth()->guard('api')->user(),
                $event->comment->recruit->first()->user_id, $event->recruit_id);
        } else if ($event->belong == 'answer') {
            $this->notifyAnswerReceiver(auth()->guard('api')->user(),
                $event->comment->answer->first()->user_id, $event->answer_id);
        }
    }

    public function notifyCommodityReceiver($request_user, $accept_user_id, $target_id)
    {
        try {
            Notification::create([
                'content' => '用户: ' . $request_user->name . ' 对您的出售物品进行了留言',
                'request_user_id' => $request_user->id,
                'accept_user_id' => $accept_user_id,
                'status' => false,
                'type' => 'commodity_comment',
                'target_id' => $target_id,
            ]);
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '创建消息通知失败，请稍后再试'
            ], 408);
        }
    }

    public function notifyArticleReceiver($request_user, $accept_user_id, $target_id)
    {
        try {
            Notification::create([
                'content' => '用户: ' . $request_user->name . ' 对您的动态进行了评论',
                'request_user_id' => $request_user->id,
                'accept_user_id' => $accept_user_id,
                'status' => false,
                'type' => 'article_comment',
                'target_id' => $target_id,
            ]);
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '创建消息通知失败，请稍后再试'
            ], 408);
        }
    }

    public function notifyActivityReceiver($request_user, $accept_user_id, $target_id)
    {
        try {
            Notification::create([
                'content' => '用户: ' . $request_user->name . ' 对您发布的活动进行了评论',
                'request_user_id' => $request_user->id,
                'accept_user_id' => $accept_user_id,
                'status' => false,
                'type' => 'activity_comment',
                'target_id' => $target_id,
            ]);
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '创建消息通知失败，请稍后再试'
            ], 408);
        }
    }

    public function notifyRecruitReceiver($request_user, $accept_user_id, $target_id)
    {
        try {
            Notification::create([
                'content' => '用户: ' . $request_user->name . ' 对您发布的招募进行了评论',
                'request_user_id' => $request_user->id,
                'accept_user_id' => $accept_user_id,
                'status' => false,
                'type' => 'recruit_comment',
                'target_id' => $target_id,
            ]);
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '创建消息通知失败，请稍后再试'
            ], 408);
        }
    }

    public function notifyAnswerReceiver($request_user, $accept_user_id, $target_id)
    {
        try {
            Notification::create([
                'content' => '用户: ' . $request_user->name . ' 对您发布的回答进行了评论',
                'request_user_id' => $request_user->id,
                'accept_user_id' => $accept_user_id,
                'status' => false,
                'type' => 'answer_comment',
                'target_id' => $target_id,
            ]);
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '创建消息通知失败，请稍后再试'
            ], 408);
        }
    }

}
