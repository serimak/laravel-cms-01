<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'username',
        'password',
        'title_id',
        'firstname_th',
        'firstname_en',
        'lastname_th',
        'lastname_en',
        'gender',
        'citizen_id',
        'passport_id',
        'status',
        'role_id',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
    protected $table = "usr_users";

    // protected $maps = [
    //   'gender' => 'UserGender',
    //   'title_id' => 'UserTitle',
    //   'firstname_th' => 'UserFirstNameTh',
    //   'middlename_th' => 'UserMiddleNameTh',
    //   'lastname_th' => 'UserLastNameTh',
    //   'firstname_en' => 'UserFirstNameEn',
    //   'middlename_en' => 'UserMiddleNameEn',
    //   'lastname_en' => 'UserLastNameEn',
    //   'citizen_id' => 'UserCitizenId',
    //   'passport_id' => 'UserPassportId',
    //   'birth_date' => 'UserBirthDate',
    //   'nationallity_id' => 'UserNationallityId',
    //   'library_code' => 'UserLibraryCode'
    // ];

    // protected $visible = ['UserGender', 'UserTitle', 'UserFirstNameTh', 'UserMiddleNameTh', 'UserLastNameTh', 'UserFirstNameEn', 'UserMiddleNameEn', 'UserLastNameEn', 'UserCitizenId', 'UserPassportId', 'UserBirthDate', 'UserNationallityId', 'UserLibraryCode'];
    // protected $appends = ['UserGender', 'UserTitle', 'UserFirstNameTh', 'UserMiddleNameTh', 'UserLastNameTh', 'UserFirstNameEn', 'UserMiddleNameEn', 'UserLastNameEn', 'UserCitizenId', 'UserPassportId', 'UserBirthDate', 'UserNationallityId', 'UserLibraryCode'];

    // public function getUserGenderAttribute()
    // {
    //     return $this->attributes['gender'];
    // }

    // public function getUserTitleAttribute()
    // {
    //     return $this->title()->get();
    // }

    // public function getUserFirstNameThAttribute()
    // {
    //     return $this->attributes['firstname_th'];
    // }

    // public function getUserMiddleNameThAttribute()
    // {
    //     return $this->attributes['middlename_th'];
    // }

    // public function getUserLastNameThAttribute()
    // {
    //     return $this->attributes['lastname_th'];
    // }

    // public function getUserFirstNameEnAttribute()
    // {
    //     return $this->attributes['firstname_en'];
    // }

    // public function getUserMiddleNameEnAttribute()
    // {
    //     return $this->attributes['middlename_en'];
    // }

    // public function getUserLastNameEnAttribute()
    // {
    //     return $this->attributes['lastname_en'];
    // }

    // public function getUserCitizenIdAttribute()
    // {
    //     return $this->attributes['citizen_id'];
    // }

    // public function getUserPassportIdAttribute()
    // {
    //     return $this->attributes['passport_id'];
    // }

    // public function getUserBirthDateAttribute()
    // {
    //     return $this->attributes['birth_date'];
    // }

    // public function getUserNationallityIdAttribute()
    // {
    //     return $this->attributes['nationallity_id'];
    // }

    // public function getUserLibraryCodeAttribute()
    // {
    //     return $this->attributes['library_code'];
    // }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }

    // public function title()
    // {
    //     return $this->belongsTo('App\Models\Title');
    // }

    public function emails()
    {
        return $this->hasMany('App\Models\Email');
    }

    // public function mobiles()
    // {
    //     return $this->hasMany('App\Models\Mobile');
    // }

    // public function addresses()
    // {
    //     return $this->hasMany('App\Models\Address');
    // }

    // public function primaryEmails()
    // {
    //     return $this->emails()->where('status', 'Primary');
    // }

    // public function primaryMobiles()
    // {
    //     return $this->mobiles()->where('status', 'Primary');
    // }

    // public function primaryAddress()
    // {
    //     return $this->addresses()->where('status', 'Primary');
    // }

    public function faculty()
    {
        return $this->belongsTo('App\Models\Faculty');
    }

    // public function major()
    // {
    //     return $this->belongsTo('App\Models\Major');
    // }

    // public function advisors() {
    //     return $this->belongsToMany('App\Models\User', 'advisor_student', 'student_id', 'advisor_id');
    // }

    public function student() 
    {
        return $this->hasMany('App\Models\Student', 'user_id');
    }

    public function studentOne() 
    {
        return $this->hasOne('App\Models\Student', 'user_id');
    }

    // public function students() {
    //     return $this->belongsToMany('App\Models\User', 'advisor_student', 'advisor_id', 'student_id');
    // }

    // public function events()
    // {
    //     return $this->hasMany('App\Models\Event');
    // }

    // public function courses()
    // {
    //     return $this->belongsToMany('App\Models\Course', 'course_advisor','advisor_id', 'course_id');
    // }

    // public function registerCourses()
    // {
    //     return $this->belongsToMany('App\Models\Course', 'course_student','student_id', 'course_id');
    // }

    public function getGroup()
    {
        return $this->hasOne('App\Models\Group', 'id', 'group_id');
    }

    public function group()
    {
        return $this->belongsToMany('App\Models\Group', 'usr_users', 'id', 'group_id');
    }

    public function getRole()
    {
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }

    public function role()
    {
        return $this->belongsToMany('App\Models\Role', 'usr_users', 'id', 'role_id');
    }

    // public function activities()
    // {
    //     return $this->hasMany('App\Models\Activity');
    // }

    // public function invitedEvents()
    // {
    //     return $this->hasMany('App\Models\EventInvitee', 'ref_id')->where('invitee_type', 'User');
    // }

    // public function notifications()
    // {
    //     return $this->hasMany('App\Models\Notification');
    // }

    public function professor()
    {
        return $this->hasOne('App\Models\Professer', 'user_id');
    }

    public function professeres()
    {
        return $this->hasMany('App\Models\Professer', 'user_id');
    }

    public function staff()
    {
        return $this->hasMany('App\Models\Staff', 'user_id');
    }

    public function imgProfile()
    {
        return $this->hasOne('App\Models\UserImg', 'user_id');
    }
}
