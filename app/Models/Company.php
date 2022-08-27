<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','description','established','website_url','company_field'
    ];

    protected $with = [
        'location'
    ];

    public function jobs()
    {
        return $this->hasMany(Jobs::class,'company_id');
    }

    public function location()
    {
        return $this->hasOne(Location::class,'company_id');
    }

}
