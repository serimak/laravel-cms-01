<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Traits\TransformableTrait;

class Route extends Model
{
  use TransformableTrait;

  protected $fillable = [
    'campus_id',
    'name_th',
    'name_en',
    'last_updated_date'
  ];

  protected $table = "unv_routes";

  public function routeData()
  {
    return $this->hasMany('App\Models\RouteData');
  }

  public function busStops()
  {
    return $this->hasMany('App\Models\BusStop');
  }

  public function places()
  {
    return $this->belongsToMany('App\Models\Place');
  }

  public function campus()
  {
    return $this->belongsTo('App\Models\Campus');
  }
}
