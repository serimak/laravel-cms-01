<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ResRegistration extends Model implements Transformable
{
    use TransformableTrait;
    //use SoftDeletes;

    protected $table = 'res_registration';

    protected $fillable = [
        'id',
        'project_name_th',
        'project_name_en',
        'responsible_person_id',
        'fiscal_year_id',
        'budget_type_id',
        'advisors',
        'agency_responsible_id',
        'budget_allocated',
        'start_date',
        'end_date',
        'job_status_id',
        'date_of_submission',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
    ];

    protected $dates = ['create_at'];

    public function resResponsiblePerson()
    {
        return $this->belongsTo('App\Models\ResResponsiblePerson');
    }

    public function resAdvisor()
    {
        return $this->hasMany('App\Models\ResAdvisor', 'id', 'res_registration_id');
    }

    public function resFiscalYear()
    {
        return $this->belongsTo('App\Models\ResFiscalYear');
    }

    public function resBudgetType()
    {
        return $this->belongsTo('App\Models\ResBudgetType');
    }

    public function resAgencyResponsible()
    {
        return $this->belongsTo('App\Models\ResAgencyResponsible');
    }

    public function resJobStatus()
    {
        return $this->belongsTo('App\Models\ResJobStatus');
    }
    
}
