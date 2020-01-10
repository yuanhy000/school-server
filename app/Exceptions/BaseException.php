<?php


namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    // HTTP状态码 404,200
    public $code = '400';
    // 具体错误信息
    public $msg = '参数错误';

    public function __construct($message = [], $code)
    {
        $this->code = $code;

        if (array_key_exists('msg', $message)) {
            $this->msg = $message['msg'];
        }
    }

}
