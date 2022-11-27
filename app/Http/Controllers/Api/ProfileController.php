<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class ProfileController extends Controller
{
    private ProfileService $profileService;

    public function __construct()
    {
        $this->profileService = new ProfileService();
    }

    public function me()
    {
        $user = $this->profileService->userProfile();
        return responseSuccess(true, 'Profile', $user, 200);
    }

    public function profile(Request $request, $id)
    {
        try {
            $user = $this->profileService->profileUpdater($id, [
                'username'      => $request->username,
                'email'         => $request->email,
                'nama_lengkap'  => $request->nama_lengkap,
                'nim'           => $request->nim,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir'  => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat
            ]);

            return responseSuccess(true, 'Success Updating Data', $user, 200);
        } catch (QueryException $error) {
            return responseError(false, $error->getMessage(), 500);
        }
    }

    public function updatePassword()
    {
        // dd($request->isJson());
        // $request->json();
        $this->validate(request(), [
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check(request()->old_password, auth()->guard('api')->user()->password)) {
            return responseError(false, 'Old Password Does Match!!', 400);
        }

        User::where('id', Auth::id())->update([
            'password' => Hash::make(request()->new_password)
        ]);

        return responseSuccess(true, 'Success Update Password', null, 200);
    }
}
