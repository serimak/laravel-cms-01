<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model 
{
    protected $table = "crs_courses";
    
    protected $fillable = [
        'subject_id',
        'term_id',
        'qr_code',
        'course_type',
        'course_module',
        'campus_id',
        'faculty_id',
        'department_id',
        'create_at',
        'update_at',
        'created_by',
        'update_by'
    ];

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject','subject_id','id');
    }

    public function term()
    {
        return $this->belongsTo('App\Models\unvSemestersTerm','term_id','id');
    }

}
