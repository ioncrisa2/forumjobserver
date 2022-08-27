<?php

namespace App\Traits;

trait JsonResponseFormat
{
    public function responseSuccess(bool $status, String $message, $data,int $code)
    {
        return response()->json([
            'status'    => $status,
            'message'   => $message,
            'data'      => $data
        ], $code);
    }

    public function responseError(bool $status, String $message, $data,int $code)
    {
        return response()->json([
            'status'    => $status,
            'message'   => $message,
            'data'      => $data
        ], $code);
    }

}
