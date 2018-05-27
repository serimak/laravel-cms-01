<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'menu_name',
        'menu_key',
        'menu_seq',
        'menu_link'
    ];

    protected $table = "cms_menu";

    public function submenu()
    {
        return $this->hasMany('App\Models\Submenu', 'menu_id');
    }

    public function permissions()
    {
        return $this->hasMany('App\Models\Permission');
    }
}