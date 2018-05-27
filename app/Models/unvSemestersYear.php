<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class unvSemestersYear extends Model
{
    protected $table = 'unv_semesters_year';
    protected $fillable = [
        'id',
        'year_name',
        'campus_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function getCampus(){
        return $this->hasOne('\App\Models\Campus','campus_id', 'id');
    }

    public function getRelatedTerms(){
        return $this->hasMany('\App\Models\unvSemestersTerm','year_id','id');
    }
}
