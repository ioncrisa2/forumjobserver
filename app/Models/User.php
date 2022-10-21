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
        'username', 'email', 'password', 'status'
    ];

    protected $hidden = ['password'];

    public function getNamaLengkapAttribute($value)
    {
        return ucwords($value);
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
        return $this->hasMany(Forum::class)->select(['id', 'nama_lengkap']);
    }

    public function forumComments()
    {
        return $this->hasMany(Comment::class);
    }

    public function jobs()
    {
        return $this->hasMany(Jobs::class);
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }
}
