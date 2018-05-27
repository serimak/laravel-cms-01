<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserLDAP extends Authenticatable implements JWTSubject
{
    use HasApiTokens, Notifiable;
    protected $table = "usr_users";
    protected $fillable = [
        'username',
        'password',
        'title_id',
        'firstname_th',
        'firstname_en',
        'middlename_th',
        'middlename_en',
        'lastname_th',
        'lastname_en',
        'gender',
        'citizen_id',
        'passport_id',
        'group_id',
        'role_id',
        'auth_type',
        'status',
    ];
    protected $hidden = [
        'password',
        'title_id',
        'group_id',
        'role_id',
    ];
    protected $appends = [
        'fullname_th',
        'fullname_en',
        'group_name_th',
        'group_name_en',
        'role_name_th',
        'role_name_en',
    ];
    protected $visible = [
        'id',
        'username',
        'fullname_th',
        'fullname_en',
        'firstname_th',
        'firstname_en',
        'middlename_th',
        'middlename_en',
        'lastname_th',
        'lastname_en',
        'group_name_th',
        'group_name_en',
        'role_name_th',
        'role_name_en',
        'gender',
        'citizen_id',
        'passport_id',
        'library_code',
        'term_condition',
        'birth_date',
        'status',
    ];
    protected $with=[ 
        'title' ,
        'group',
        'role'
    ];
    protected $includeWith=[];
    
    public function getTermConditionAttribute()
    {
        return ($this->attributes['term_condition']==0)?'Y':'N';
    }
    public function getFullnameThAttribute()
    {
        return implode(' ', array(
            $this->title->title_name_th,
            $this->firstname_th, 
            $this->middlename_th, 
            $this->lastname_th
        ));
    }
    public function getFullnameEnAttribute()
    {
        return implode(' ', array(
            $this->title->title_name_en,
            $this->firstname_en, 
            $this->middlename_en, 
            $this->lastname_en
        ));
    }
    public function getGroupNameThAttribute()
    {
        return $this->group->group_name_th;
    }
    public function getGroupNameEnAttribute()
    {
        return $this->group->group_name_en;
    }
    public function getRoleNameThAttribute()
    {
        return $this->role->role_name;
    }
    public function getRoleNameEnAttribute()
    {
        return $this->role->role_name;
    }
    public function title()
    {
        return $this->belongsTo('App\Models\UserTitle','title_id','id')->withDefault([
	        'title_name_th' => 'คุณ',
			'title_name_en' => 'Khun'
        ]);
    }
    public function group()
    {
        return $this->belongsTo('App\Models\UserGroup','group_id','id')->withDefault([
            'id' => 5,
            'title_name_th' => 'อื่น ๆ',
			'title_name_en' => 'Other'
        ]);
    }
    public function role()
    {
        return $this->belongsTo('App\Models\UserRole','role_id','id')->withDefault([
	        'id' => 5,
            'title_name_th' => 'อื่น ๆ',
			'title_name_en' => 'Other'
        ]);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
