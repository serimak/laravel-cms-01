<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ResAgencyResponsible extends Model implements Transformable
{
    use TransformableTrait;
    //use SoftDeletes;

    protected $table = 'res_agency_responsible';

    protected $fillable = [
        'id',
        'name_th',
        'name_en',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
    ];

    protected $dates = ['create_at'];
    
}
