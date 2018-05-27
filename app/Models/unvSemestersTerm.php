<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class unvSemestersTerm extends Model
{
    protected $table = 'unv_semesters_term';
    protected $fillable = [
        'term_name',
        'year_id',
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

    public function getRelatedYear(){
        return $this->belongsTo('\App\Models\unvSemestersYear', 'year_id', 'id');
    }
}
