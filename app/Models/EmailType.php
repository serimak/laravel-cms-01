<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailType extends Model
{
    protected $fillable = [
        'id',
        'type_name_th',
        'type_name_en',   
    ];

    protected $table = "usr_email_types";

    public function email()
    {
        return $this->hasOne('App\Models\Email');
    }
}
