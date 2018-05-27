<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model 
{

    protected $table = "usr_students";
    
    protected $fillable = [
        'user_id',
        'student_code',
        'campus_id',
        'faculty_id',
        'department_id',
        'major_id',
        'degree_id',
        'card_expiry_date',
        'card_issue_date',
        'student_status',
        'library_id',
        'year'
    ];

    public function faculty()
    {
        return $this->hasOne('App\Models\Faculty', 'id', 'faculty_id');
    }
}
