<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        try{
            $user = User::select('id','nim','nama_lengkap','created_at')->where('status','ALUMNI')->paginate(10);
            return responseSuccess(true,'Semua Data Alumni',$user,Response::HTTP_OK);
        }catch(QueryException $e){
            return responseError(false,$e->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

}
