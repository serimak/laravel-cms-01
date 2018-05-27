<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model 
{

    protected $table = "sec_sections";
    
    protected $fillable = [
        'section_name',
        'course_id',
        'section_quota',
        'reserve',
        'section_status',
        'create_at',
        'update_at',
        'created_by',
        'update_by'
    ];


}
