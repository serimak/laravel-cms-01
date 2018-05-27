<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $fillable = [
        'title_name_th',
        'title_name_en'
    ];

    protected $table = "usr_titles";
}