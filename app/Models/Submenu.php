<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
//    public $timestamps = false;
    protected $fillable = [
        'submenu_name',
        'submenu_key',
        'submenu_seq',
        'submenu_link',
        'menu_id',
        'icon'
    ];

    protected $table = "cms_submenu";
}