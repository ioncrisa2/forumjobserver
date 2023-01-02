<?php

namespace App\Models;

// use App\Traits\IndonesiaTimeFormat;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'user_id', 'job_name',
        'job_description', 'poster', 'end_date'
    ];

    protected $with = [
        'user', 'types', 'company'
    ];

    public function getEndDateAttribute($EndDate)
    {
        return Carbon::parse($EndDate)->format('Y-m-d');
    }

    public function company()
    {
        return $this->belongsTo(Company::class)->select(['id', 'name']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select(['id', 'username']);
    }

    public function types()
    {
        return $this->belongsToMany(Types::class, 'job_type', 'jobs_id', 'types_id');
    }
}
