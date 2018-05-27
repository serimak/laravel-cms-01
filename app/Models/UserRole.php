<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = "aut_role";
    protected $fillable = [
        'role_name',
        'cms_level',
        'sa_level',
    ];
}
