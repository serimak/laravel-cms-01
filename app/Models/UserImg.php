<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserImg extends Model 
{

    protected $table = "usr_users_img";
    
    protected $fillable = [
    	'id',
        'user_id',
        'path',
        'img_type',
        'created_by',
        'updated_by'
    ];

}
