<?php

namespace App\Events;

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

class CreateCommodity
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $commodity_id;
    public $name;
    public $description;
    public $price;
    public $image_list;
    public $category_id;
    public $display_location;
    public $location;

    public function __construct($request_info)
    {
        $this->name = $request_info['commodity_name'];
        $this->description = $request_info['commodity_description'];
        $this->price = (float)$request_info['commodity_price'];
        $this->image_list = $request_info['commodity_image'];
        $this->category_id = $request_info['category_id'];
        $this->display_location = json_decode($request_info['is_display_location']);
        $this->location = $request_info['location'];
        $this->createCommodity();
    }

    private function createCommodity()
    {
        try {
            $this->commodity_id = Commodity::create([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'user_id' => auth()->guard('api')->user()->id,
                'category_id' => $this->category_id,
                'display_location' => $this->display_location,
                'location' => $this->location,
            ])->id;
        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '发布商品失败，请稍后'
            ], 408);
        }
    }
}
