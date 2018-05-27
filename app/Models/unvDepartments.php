<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class unvDepartments extends Model
{
    protected $table = 'unv_departments';
    protected $fillable = [
        'department_ref_id',
        'department_name_th',
        'department_name_en',
        'department_code',
        'faculty_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function getCourse() {
        return $this->hasOne('\App\Models\Course', 'id', 'course_id');
    }
}
