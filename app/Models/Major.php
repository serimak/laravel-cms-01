<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Major extends Model implements Transformable
{
    use TransformableTrait;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'major_name_th',
        'major_name_en',
        'major_ref_id'
    ];

    protected $table = "unv_majors";

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function faculty()
    {
        return $this->belongsTo('App\Models\Faculty');
    }

    public function subjects()
    {
        return $this->hasMany('App\Models\Subject');
    }
    public function majorEvents()
    {
        return $this->hasMany('App\Models\EventInvitee', 'ref_id')->where('invitee_type', 'Major');
    }
}
