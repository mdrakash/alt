<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

        if($this->end_time) {
            $endTime = Carbon::parse($this->end_time);
            $interval = $startTime->diff($endTime);
            return $interval->format('%h hours, %i minutes, %s seconds');
        } else {
            return 'Work in progress';
        }
    }

    protected function startTime(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
        );
    }

    protected function endTime(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Carbon::parse($value)
        );
    }
}
