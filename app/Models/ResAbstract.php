<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ResAbstract extends Model implements Transformable
{
    use TransformableTrait;
    //use SoftDeletes;

    protected $table = 'res_abstract';

    protected $fillable = [
        'id',
        'res_registration_id',
        'abstract_th',
        'abstract_en',
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