<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEmail extends Model
{
    protected $table = "usr_emails";
    protected $fillable = [
        'user_id',
        'email_name',
        'type',
        'active',
        'created_by',
        'updated_by'
    ];
}
