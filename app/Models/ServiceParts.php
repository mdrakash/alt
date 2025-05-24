<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceParts extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function service()
    {
        return $this->belongsTo(Services::class, 'services_id');
    }

    public function parts()
    {
        return $this->belongsTo(Parts::class, 'parts_id');
    }
}
