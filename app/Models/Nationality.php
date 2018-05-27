<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    protected $fillable = [
        'nationality_name'
    ];

    protected $table = "usr_nationalities";
}