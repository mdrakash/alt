<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceParts extends Model
{
    protected $fillable = [
        'services_id',
        'parts_id',
        'quantity'
    ];

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
