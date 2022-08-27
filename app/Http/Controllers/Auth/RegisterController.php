<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try{
            $request->validated();

            $user = User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nim' => $request->nim
            ]);

           return responseSuccess(true,'Register Successfully',$user,Response::HTTP_CREATED);

        }catch(QueryException $e){
            return responseError(false,$e->getMessage(),Response::HTTP_BAD_REQUEST);
        }

    }
}
