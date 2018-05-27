<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStaff extends Model
{
    protected $table = "usr_staff";
    protected $fillable = [
	    'user_id',
		'staff_code',
		'created_by',
		'updated_by'
    ];
}
