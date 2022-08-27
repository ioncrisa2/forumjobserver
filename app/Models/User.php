<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\IndonesiaTimeFormat;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, IndonesiaTimeFormat;

    protected $fillable = [
        'nama_lengkap','username','nim','email','password',
        'alamat','telepon','tanggal_lahir','status'
    ];

    protected $hidden = ['password'];

    public function getNamaLengkapAttribute($value)
    {
       return ucwords($value);
    }

    public function getTanggalLahirAttribute($tanggal_lahir)
    {
        $value = Carbon::parse($tanggal_lahir);
        $parse = $value->locale('id');
        return $parse->translatedFormat('d F Y');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function forums()
    {
        return $this->hasMany(Forum::class)->select(['id','nama_lengkap']);
    }

    public function forumComments()
    {
        return $this->hasMany(Comment::class);
    }

    public function jobs()
    {
        return $this->hasMany(Jobs::class);
    }
}
