<?php

namespace App;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    protected $guarded = [];

    public static function isFollowUser($accept_id, $request_id)
    {
        $result = self::where([
            ['accept_id', '=', $accept_id],
            ['request_id', '=', $request_id]
        ])->first();

        if ($result) {
            return $result;
        }
        return false;
    }

    public static function toggleUserFollow($result, $accept_id, $request_id)
    {
        try {
            if ($result) {
                $result->delete();
                User::followerDecrement($accept_id);
                User::attentionDecrement($request_id);
            } else {
                self::create([
                    'accept_id' => $accept_id,
                    'request_id' => $request_id,
                ]);
                User::followerIncrement($accept_id);
                User::attentionIncrement($request_id);
            }
            return response()->json([
                'message' => '操作成功'
            ], 201);

        } catch (Exception $exception) {
            throw new BaseException([
                'msg' => '操作失败，请稍后再试'
            ], 408);
        }
    }
}
