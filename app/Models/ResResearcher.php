<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ResResearcher extends Model implements Transformable
{
    use TransformableTrait;
    //use SoftDeletes;

    protected $table = 'res_researcher';

    protected $fillable = [
        'id',
        'res_registration_id',
        'res_responsible_person_id',
        'name_th',
        'name_en',
        'percent',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
    ];

    protected $dates = ['create_at'];

    public function resRegistration()
    {
        return $this->belongsTo('App\Models\ResRegistration');
    }
    
}