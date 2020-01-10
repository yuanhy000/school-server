<?php

namespace App\Events;

use App\Commodity;
use App\Exceptions\BaseException;
use App\Organization;
use Exception;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplyOrganization
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $organization_id;
    public $name;
    public $description;
    public $image_list;

    public function __construct($request_info)
    {
        $this->name = $request_info['organization_name'];
        $this->description = $request_info['organization_description'];
        $this->image_list = $request_info['organization_image'];
        $this->createOrganization();
    }

    private function createOrganization()
    {
        try {
            $this->organization_id = Organization::create([
                'name' => $this->name,
                'description' => $this->description,
                'user_id' => auth()->guard('api')->user()->id,
            ])->id;
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '申请认证失败，请稍后再试'
            ], 408);
        }
    }
}
