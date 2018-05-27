<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'role_id',
        'cms_ref_id',
        'cms_ref_type',
        'icon'
    ];

    protected $table = "aut_role_permission";

    public function role()
    {
        return $this->belongsToMany('App\Models\Role')->withTimestamps();
    }
}