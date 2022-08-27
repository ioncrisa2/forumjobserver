<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function me()
    {
       return responseSuccess(true,'Profile',auth()->guard('api')->user(),200);
    }

    public function profile(Request $request,User $user)
    {
        try{
            $data = array(
                'nama_lengkap' => $request->nama_lengkap != null ? $request->nama_lengkap : $user->nama_lengkap,
                'username' => $request->username != null ? $request->username : $user->username,
                'nim' => $request->nim != null ? $request->nim : $user->nim,
                'email' => $request->email != null ? $request->email : $user->email,
                'alamat' => $request->alamat != null ? $request->alamat : $user->alamat,
                'telepon' => $request->telepon != null ? $request->telepon : $user->telepon,
                'tanggal_lahir' => $request->tanggal_lahir != null ? $request->tanggal_lahir : $user->tanggal_lahir
            );

            $user->update($data);

          return responseSuccess(true,'Profile Updated',$user,200);

        }catch(QueryException $e){
          return responseError(false,$e->getMessage(),500);
        }

    }
}
