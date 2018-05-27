<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = "usr_groups";
    protected $fillable = [
        'group_name_th',
        'group_name_en'
    ];
}
