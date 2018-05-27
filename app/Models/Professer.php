<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professer extends Model 
{

    protected $table = "usr_professers";
    
    protected $fillable = [
        'user_id',
        'professer_code',
        'campus_id',
        'faculty_id',
        'department_id',
        'major_id'
    ];

    public function faculty()
    {
        return $this->hasOne('App\Models\Faculty', 'id', 'faculty_id');
    }
}
