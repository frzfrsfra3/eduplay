<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravolt\Avatar\Avatar;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{

    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    /*** Attributes that should be mass-assignable. ** @var array */
    protected $fillable = [
                  'name',
                  'email',
                  'provider',
                  'provider_id',
                  'mobile',
                  'devicetype',
                  'gender',
                  'password',
                  'user_image',
                  'isactive',
                  'child_password_reset',
                  'isverified',
                  'role_type_id',
                  'grade_id',
                  'school_id',
                  'parent_id',
                  'country_id',
                  'uilanguage_id',
                  'dob',
                  'phone',
                  'parentmail',
                  'isapproved_byparent',
                  'isintroinfo_displayed',
                  'passwordtoken',
                  'registeredby',
                  'totalpoints',
                  'remember_token',
                  'aboutme',
                  'native_language',
                  'linkedin_url',
                  'city',
                  'state',
                  'verified_token',
                  'is_email_active',
                  'visit_tour',
                  'quota',
              ];

    // protected $dateFormat='U'; The attributes that should be mutated to dates.
    protected $dates = [
        //'dob',
        'lastloggedon',
        'registeredon'

    ];

    // The attributes that should be cast to native types.
    protected $casts = [];

    public static function boot()
    {
        parent::boot();

        static::deleting(function($user)
        {
            $user->roles()->detach();
            $user->useractivitylog()->delete();
            $user->badges()->detach();
            $user->userexamanswer()->delete();
            $user->userexamscore()->delete();
            $user->userinterest()->delete();
            $user->userNotifications()->delete();
            $user->userSkillmasterylevel()->delete();
        });
    }
    // Set & Get password Accessor & Mutator
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value; //encrypt($value);
    }

    public function getPasswordAttribute($value)
    {
        return $value;// decrypt($value);
    }

    //authorizing roles
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            if ($this->hasAnyRole($roles)) {
                return $this->hasAnyRole($roles);
            }
            else {
                abort(401, 'This action is unauthorized. Need more priviliges');
            }
        }
        return $this->hasRole($roles) ||
                abort(401, 'This action is unauthorized by rule2.');
    }

    // Check multiple roles
    public function hasAnyRole($roles)
    {
        $value = true;
        $returnedrole = $this->roles()->get()->whereIn('name', $roles);
        if (count($returnedrole) == 0) {
            $value = false;
        }
        return $value;
    }

    // Check one role
    public function hasRole($role)
    {
        $value = true;
        $returnedrole= $this->roles()->get()->where('name', $role);
        if (count($returnedrole) == 0) {
            $value = false;
        }
        return $value;
    }

    // Defining User Parent-Child Relationships
    public function parent_requests()
    {
        return $this->hasMany('App\Models\ParentRequest', 'parent_id', 'id');
    }

    // Defining User Child-Parent relationships
    public function parent_requests_for_child()
    {
        return $this->hasMany('App\Models\ParentRequest', 'child_id', 'id');
    }

    // Get tje user parent
    public function parent()
    {
        return $this->belongsTo('App\Models\User','parent_id');
    }

    // get the user roles
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    //get the user grade if any
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade','grade_id');
    }

    // get the user school
    public function school()
    {
        return $this->belongsTo('App\Models\School','school_id','id');
    }

    //get the user's pending tasks
    public function pendingtasks()
    {
        return $this->hasMany('App\Models\Pendingtask');
    }

    // get the user skill mastery level
    public function userSkillmasterylevel()
    {
        return $this->hasMany('App\Models\UserSkillmasterylevel','user_id');
    }

    //get the user country
    public function country()
    {
        return $this->belongsTo('App\Models\Country','country_id');
    }

    //get the user preferred ui language
    public function uilanguage()
    {
        return $this->belongsTo('App\Models\Language','uilanguage_id');
    }

    // get the user selected plan for each role
    public function userplans()
    {
        return $this->hasMany('App\Models\UserSubscriptions', 'user_id', 'id');
    }

    // Get the CoursesClasses this user is enrolled in.
    public function enrolledclasses()
    {
        return $this->belongsToMany('App\Models\Courseclass','classlearners','user_id','class_id')
            ->withPivot(['joindate' ,'status' ,'id']);
    }

    /**
     * Get class learners -  Develop by WC --TODO Check when this function is used, and when the above is used
     */
    public function getLearner()
    {
        return $this->hasMany('App\Models\Classlearner','class_id');
    }

    // Check if the user isCollaborator for this discipline.
    public function iscollaborator($discipline)
    {
        // need to be checked written by Ismail
        if (count ($this->hasMany('App\Models\Disciplinecollaborator','user_id','id')->where(discipline_id==$discipline)->get())){
            return true;
        }
        return false;
    }

    // Get the Exercises followed or bought by this User
    public function exercises()
    {
        return $this->belongsToMany('App\Models\Exerciseset','exercisesetbuyers', 'user_id', 'exerciseset_id')->where('publish_status','=','public');
    }

    // Get the Exercises created by this User
    public function myexercises()
    {
        return $this->hasMany('App\Models\Exerciseset', 'createdby' );
    }

    // Set & Get  the LastLoggedOn.
    public function setLastloggedonAttribute($value)
    {
        $this->attributes['lastloggedon'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    public function getLastloggedonAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    // Get the useractivitylog --TODO check why this relation is not hasmany
    public function useractivitylog()
    {
        return $this->hasOne('App\Models\Useractivitylog','user_id','id');
    }

    // Get the Login Activities for this model.
    public function userloginactivities()
    {
        return $this->hasMany('App\Models\LoginActivity','user_id','id');
    }

    //Get the badges for this user.
    public function badges()
    {
        return $this->belongsToMany('App\Models\Badge','userbadges','user_id','badge_id')
            ->withPivot(['dateacquired'  ,'id']);
    }

    // Get the userexamanswer for this model.
    public function userexamanswer()
    {
        return $this->hasMany('App\Models\Userexamanswer','user_id','id');
    }

    // Get the userexamscore for this model.
    public function userexamscore()
    {
        return $this->hasMany('App\Models\Userexamscore','user_id','id');
    }

    // Get the exams created by this user as teacher
    public function myexams(){

        return $this->hasMany ('App\Models\Exam' , 'teacheruser_id','id');
    }

    // Get User game preferences codes
    public function gamepreferencescodes(){

        return $this->hasMany ('App\Models\gamePreference' , 'user_id','id');
    }

    // Get all userinterest
    public function userinterest()
    {
        return $this->hasMany('App\Models\Userinterest','user_id','id');
    }
    // Get userinterest for specific Discipline??
    public function disciplines()
    {
        return $this->belongsToMany('App\Models\Discipline','userinterests', 'user_id', 'discipline_id');
    }

    // Calculate how much of the profile is completed
    public function calculate_profile($profile)
    {
        if ( ! $profile) {
            return 0;
        }
        unset($profile['id'],$profile['grade_id'],$profile['created_at']);
        $columns    = preg_grep('/(.+ed_at)|(.*id)/', array_keys($profile->toArray()), PREG_GREP_INVERT);
        array_push($columns,"country_id","uilanguage_id");
        $per_column = 100 / count($columns);
        $total      = 0;
        foreach ($profile->toArray() as $key => $value) {
            if ($value !== NULL && $value !== '' && in_array($key, $columns)) {
                $total += $per_column;
            }
        }
        $total=intval($total);
        return $total;
    }

    /**
     * Get all classes created by this user as a teacher - Develop by WC
     */
    public function teacherClass()
    {
        return $this->hasMany('App\Models\Courseclass', 'teacher_userid');
    }
    //--TODO Check duplicate function
    public function teacherClasses()
    {
        return $this->hasMany('App\Models\Courseclass', 'teacher_userid');
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

    /**
     * Undocumented function
     */
    public function userNotifications()
    {
        return $this->hasMany('App\Models\Notificationsaction', 'user_id');
    }

    // Set & Get the Registeredon.
    public function setRegisteredonAttribute($value)
    {
        $this->attributes['registeredon'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    public function getRegisteredonAttribute($value)
    {
        return date('j/n/Y g:i authorizeRoles', strtotime($value));
    }

    // Get created_at
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    // Get updated_at
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
