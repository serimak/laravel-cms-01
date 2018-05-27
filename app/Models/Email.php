<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'email_name',
        'type',
        'active',    
    ];

    protected $table = "usr_emails";

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function type(){
        return $this->belongsTo('App\Models\EmailType');
    }
}
