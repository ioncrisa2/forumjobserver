<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Traits\IndonesiaTimeFormat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Forum extends Model
{
    use HasFactory, IndonesiaTimeFormat;

    protected $fillable = ['title', 'body', 'slug', 'category', 'user_id'];

    protected $with = ['user', 'comments'];

    public function getTitleAttribute($value)
    {
        return Str::title($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select(['id', 'username']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->select(['id', 'forum_id', 'body', 'user_id', 'created_at']);
    }
}
