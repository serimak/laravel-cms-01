<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    protected $fillable = [
    	'role_name',
    	'cms_level',
    	'sa_level'
    ];

    protected $table = "aut_role";

    public function permissions()
    {
        return $this->hasMany('App\Models\Permission');
    }
}