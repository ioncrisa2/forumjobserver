<?php

namespace App\Traits;

use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

trait AuthUser
{
    private function getAuthUser()
    {
        try{
            return auth('api')->userOrFail();
        }catch(UserNotDefinedException $e){
            response()->json([
                'message' => 'not authorized, you need to login first!'
            ],401)->send();
            exit;
        }
    }

    private function checkOwnership($owner)
    {
        $user = $this->getAuthUser();

        if($user->id != $owner){
            response()->json(['message' => 'not authorized user!'],403)->send();
            exit;
        }
    }
}
