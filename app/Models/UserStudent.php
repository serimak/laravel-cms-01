<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStudent extends Model
{
    protected $table = "usr_students";
    protected $fillable = [
	   'user_id',
	    'student_code',
	    'campus_id',
	    'firstname_en',
	    'lastname_en',
	    'faculty_id',
	    'department_id',
	    'major_id',
	    'degree_id',
	    'card_issue_date',
	    'card_expiry_date',
	    'library_id',
	    'year',
	    'created_by',
	    'updated_by',
    ];
    protected $dates = [
    	'card_issue_date',
		'card_expiry_date'
    ];
    
    public function Faculty()
    {
        return $this->hasOne('App\Models\Faculty','id', 'faculty_id')->select(array('id', 'faculty_name_en'));

    }
}
