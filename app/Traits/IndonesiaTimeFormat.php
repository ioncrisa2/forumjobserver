<?php

namespace App\Traits;

use Carbon\Carbon;

trait IndonesiaTimeFormat
{
    public function getCreatedAtAttribute($created_at)
    {
        $value = Carbon::parse($created_at);
        $parse = $value->locale('id');
        return $parse->translatedFormat('d F Y');
    }

    public function getUpdatedAtAttribute($updated_at)
    {
        $value = Carbon::parse($updated_at);
        $parse = $value->locale('id');
        return $parse->translatedFormat('d F Y');
    }
}
