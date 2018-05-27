<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    protected $fillable = [
        'group_name_th',
        'group_name_en'
    ];

    protected $table = "usr_groups";
}