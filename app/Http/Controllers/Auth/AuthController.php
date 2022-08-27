<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        return auth()->shouldUse('api');
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(LoginRequest $request)
    {
        $request->validated();
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email or Password is Incorrect'
            ], 401);
        }

        return responseWithToken(true, 'Berhasil Login!', auth()->guard('api')->user(), $token);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return responseSuccess(true, 'Logout Successfully', null, 200);
        } catch (Throwable $e) {
            return responseError(false, $e->getMessage(), 500);
        }
    }

    public function refresh(Request $request)
    {
        $refreshToken = JWTAuth::refresh(JWTAuth::getToken());
        $user = JWTAuth::setToken($refreshToken)->toUser();

        $request->headers->set('Authorization', 'Bearer ' . $refreshToken);

        return responseWithToken(true, 'refresh token', $user, $refreshToken);
    }
}
