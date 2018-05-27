<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model 
{

    protected $table = "crs_subjects";
    
    protected $fillable = [
        'subject_code',
        'subject_name_th',
        'subject_name_en',
        'subject_descrpition_th',
        'subject_descrpition_en',
        'credit',
        'credit_lacture',
        'credit_laboratory',
        'credit_carries',
        'campus_id',
        'faculty_id',
        'department_id',
        'create_at',
        'update_at',
        'created_by',
        'update_by'
    ];

    public function courses()
    {
        return $this->hasMany('App\Models\Course');
    }

}
