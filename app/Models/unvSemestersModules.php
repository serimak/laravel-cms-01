<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class unvSemestersModules extends Model
{
    protected $table = 'unv_semester_modules';
    protected $fillable = [
        'term_id',
        'year_id',
        'module',
        'module_name',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
