<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTitle extends Model
{
    protected $fillable = [
        'title_name_th',
        'title_name_en',
        'created_by',
        'updated_by'
    ];
    protected $hidden = [];
    protected $table = "usr_titles";
}
