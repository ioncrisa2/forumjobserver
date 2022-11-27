<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function userProfile()
    {
        $user = User::with('detail')->find(Auth::id());
        return $user;
    }

    public function profileUpdater($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->save();

        $detail = [
            'nama_lengkap'  => $data['nama_lengkap'],
            'nim'           => $data['nim'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'tempat_lahir'  => $data['tempat_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'alamat'        => $data['alamat'],
        ];

        if ($user->detail === null) {
            $user->detail()->save($detail);
        } else {
            $user->detail->update($detail);
        }

        return $user;
    }
}
