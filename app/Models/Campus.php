<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $fillable = [
        'campus_ref_id',
        'campus_name_th',
        'campus_name_en',
        'latitude',
        'longitude',
        'radius',
        'created_by',
        'updated_by'
    ];

    protected $table = "unv_campuses";
}