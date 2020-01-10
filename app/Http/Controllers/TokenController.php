<?php

namespace App\Http\Controllers;

use App\Exceptions\BaseException;
use App\User;
use App\UserNumberIncrement;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    public $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    public function getToken(Request $request)
    {
        $code = $request->all()['code'];
        $openid = $this->getOpenid($code);
        $user = $this->checkUserExist($openid);

        return $this->proxy('password', [
            'username' => $openid,
            'password' => '123',
            'scope' => '*'
        ]);
    }

    public function refreshToken(Request $request)
    {
        $refreshToken = $request->all()['refresh_token'];
        return $this->proxy('refresh_token', [
            'refresh_token' => $refreshToken
        ]);
    }

    public function proxy($grantType, array $data)
    {
        $data = array_merge($data, [
            'client_id' => env('client_id'),
            'client_secret' => env('client_secret'),
            'grant_type' => $grantType,
        ]);
        $response = $this->http->post(env('APP_URL') . '/oauth/token', [
            'form_params' => $data,
        ]);

        $token = json_decode((string)$response->getBody(), true);
        return [
            'access_token' => $token['access_token'],
//            'auth_id' => md5($token['refresh_token']),
            'refresh_token' => $token['refresh_token'],
            'expires_in' => $token['expires_in'],
        ];
    }

    public function cleanToken()
    {
//        event(new UserLogout($user = auth()->guard('api')->user()));
//        $user = auth()->guard('api')->user();
//
//        $accessToken = $user->token();
//        DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)
//            ->update([
//                'revoked' => 1
//            ]);
//        $accessToken->revoke();
        return response()->json([
            'message' => 'Token has been clean!'
        ], 202);
    }

    public function getOpenid($code)
    {
        $app_id = config('private.app_id');
        $app_secret = config('private.app_secret');
        $request_url = sprintf(config('private.login_url'), $app_id, $app_secret, $code);

        $result = $this->http->get($request_url);
        $response = json_decode((string)$result->getBody());

        if (empty($response)) {
            throw new Exception('获取session_key和openID异常，QQ内部错误');
        } else {
            if ($response->errcode == 0) {
                return $response->openid;
            } else {
                throw new BaseException([
                    'msg' => $response->errmsg
                ], 408);
            }
        }
    }

    public function checkUserExist($openid)
    {
        $user = User::where('openid', '=', $openid)->get();

        if (empty(json_decode($user, true))) {
            UserNumberIncrement::NumberIncrement();
            return User::create([
                'openid' => $openid,
                'number' => UserNumberIncrement::first()->user_number
            ]);
        } else {
            return $user;
        }
    }
}
