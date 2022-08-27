<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['company_id','street_address','country','state','city','zip_code'];

    public function company()
    {
        return $this->belongsTo(Company::class)->select(['id','name']);
    }
}
