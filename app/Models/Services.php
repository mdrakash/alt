<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Services extends Model
{
    protected $guarded = [];
    protected $appends = ['actual_time'];

    public $timestamps = false;

    public function serviceParts()
    {
        return $this->hasMany(ServiceParts::class);
    }

    public function getActualTimeAttribute()
    {
        $startTime = Carbon::parse($this->start_time);
        $endTime = Carbon::parse($this->end_time);

        $interval = $startTime->diff($endTime);

        return $interval->format('%h hours, %i minutes, %s seconds');
    }

    public function setEndTimeAttribute($value)
    {
        return Carbon::parse($value);
    }
}
