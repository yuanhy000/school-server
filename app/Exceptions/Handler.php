<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];


    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    private $code;
    private $msg;

    public function render($request, Exception $exception)
    {
        if ($exception instanceof BaseException) {
            $this->code = $exception->code;
            $this->msg = $exception->msg;
        } else {
            if (config('app.debug')) {
                return parent::render($request, $exception);
            } else {
                $this->code = 500;
                $this->msg = '服务器内部错误，不想告诉你';
            }
        }
        $result = [
            'code' => $this->code,
            'msg' => $this->msg,
            'request_url' => $request->url()
        ];
        return response()->json($result, $this->code);
    }
}
