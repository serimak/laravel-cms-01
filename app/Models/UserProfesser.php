<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfesser extends Model
{
    protected $table = "usr_professers";
    protected $fillable = [
	    'user_id',
		'professer_code',
		'campus_id',
		'major_id',
		'department_id',
		'faculty_id',
		'created_by',
		'updated_by'
    ];
}
