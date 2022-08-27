<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\IndonesiaTimeFormat;

class Comment extends Model
{
    use HasFactory, IndonesiaTimeFormat;

    protected $fillable = ['body','forum_id','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['id','username']);
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

}
