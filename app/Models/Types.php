<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'types';

    protected $fillable = ['name'];

    public function jobs()
    {
        return $this->belongsToMany(Jobs::class, 'job_type', 'types_id', 'jobs_id');
    }
}
