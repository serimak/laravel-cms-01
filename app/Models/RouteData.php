<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Traits\TransformableTrait;

class RouteData extends Model
{
    use TransformableTrait;

    protected $fillable = [
        'route_id',
        'latitude',
        'longitude',
        'seq'
    ];

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
        'seq' => 'double'
    ];

    protected $table = "unv_route_datas";

    public function route()
    {
        return $this->belongsTo('App\Models\Route');
    }
}
