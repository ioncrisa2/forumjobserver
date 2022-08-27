<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\IndonesiaTimeFormat;

class Forum extends Model
{
    use HasFactory,IndonesiaTimeFormat;

    protected $fillable = ['title','body','slug','category','user_id'];

    protected $with = ['user','comments'];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['id','username']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->select(['id','forum_id','body','user_id','created_at']);
    }

}
