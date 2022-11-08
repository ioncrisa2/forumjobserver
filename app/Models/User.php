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
        'username', 'email', 'password', 'role_id'
    ];

    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function forums()
    {
        return $this->hasMany(Forum::class);
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
        return $this->hasOne(UserDetail::class, 'user_id');
    }
}
