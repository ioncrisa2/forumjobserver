<?php

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

function responseSuccess(bool $status, String $message, mixed $data, int $code): JsonResponse
{
    return response()->json([
        'status'    => $status,
        'message'   => $message,
        'data'      => $data
    ], $code);
}

function responseError(bool $status, String $message, int $code): JsonResponse
{
    return response()->json([
        'status'    => $status,
        'message'   => $message,
    ], $code);
}

function responseWithToken(bool $status, String $message, $user, $token): JsonResponse
{
    return response()->json([
        'success' => $status,
        'message' => $message,
        'token' => $token,
        'user' => $user,
    ], Response::HTTP_OK);
}
