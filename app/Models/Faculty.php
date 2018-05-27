<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Faculty extends Model implements Transformable
{
    use TransformableTrait;
    public $incrementing = false;
    protected $fillable = [
        'campus_id',
        'faculty_name_th',
        'faculty_name_en',
        'faculty_ref_id'
    ];

    protected $table = "unv_faculties";

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function campuses()
    {
        return $this->belongsTo('App\Models\Campus');
    }

    public function majors()
    {
        return $this->hasMany('App\Models\Major');
    }

    public function subjects()
    {
        return $this->hasMany('App\Models\Subject');
    }
    public function facultyEvents()
    {   
        return $this->hasMany('App\Models\EventInvitee', 'ref_id')->where('invitee_type', 'Faculty');
    }
}
