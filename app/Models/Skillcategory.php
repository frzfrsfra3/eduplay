<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Skill;

class Skillcategory extends Model
{
    use HasFactory;
    protected $hidden = array('pivot');
    protected $table = 'skillcategories';

    protected $primaryKey = 'id';
    protected $fillable = [
                  'discipline_id',
                  'skill_category_name',
                  'skill_category_decsription',
                  'description_Fr',
                  'description_Ar',
                  'version',
                  'sort_order',
                  'duration',
                  'moderatedby',
                  'approve_status',
                  'publish_status',
                  'createdby',
                  'updatedby',
                  'origin_id'
              ];

    protected $dates = [];
    protected $casts = [];

    /**
     * Get the discipline related to this skill category.
     */

/** @var \Illuminate\Database\Eloquent\Factory $factory */
    public function discipline()
    {
        return $this->belongsTo('App\Models\Discipline','discipline_id');
    }

    /**
     * Get the skills of this skill category.
     */
    public function skill()
    {
        return $this->hasMany('App\Models\Skill','skill_category_id','id');
    }

    /**
     * Get the grades of this skill category.
     */
    public function grades(){

        return $this->belongsToMany('App\Models\Grade','skills','grade_id'  ,'skill_category_id' );

    }

    public function skillCategoryGrade(){

        return $this->belongsToMany('App\Models\Grade','skills','skill_category_id'  ,'grade_id' );
    }

    /**
     * Get the discipline of this skill category.
     */
    public function get_disciplinename()
    {
        $topic=Discipline::where ( 'id',$this->discipline_id )->first();
        return  $topic->discipline_name;
    }

    /**
     * Get the questions that are linked to this skill_category.
     */
    public function question()
    {
        return $this->hasMany('App\Models\Question','skillcategory_id','id');
    }

    public function SkillExamCategories()
    {
        return $this->belongsToMany('App\Models\Exam', 'exam_skill_categories', 'skill_category_id', 'exam_id')->withTimestamps();
    }

    /**
     * skill category versionning functions
     */
    // --------------------------------------------------------------------------------
    public function skillofsameversion($lastversion )
    {
      return $this->skill()->where( [['version','=' ,$lastversion],['publish_status' ,'=','published']])
                       ->orwhere ([['version','>' ,$lastversion],['skill_category_id', '=' ,$this->id],['origin_id' ,'=', 0]]);

    }

    public function count_of_skill_children($lastversion )
    {
        return   $skills=$this->skill()->where( 'version','>' ,$lastversion)->get()->count();
    }

    public function getchildren()
    {
        $children=$this::where ( 'origin_id' ,'=' ,$this->id )->get();
        return  $children;
    }


    public function havenotdeltedskill($lastversion)
    {
        $skills=    $this->skill()->where( [['version','=' ,$lastversion+1],['publish_status' ,'<>','deleted'],['updatedby','=',Auth::user() ->id]])
                         ->orwhere ([['version','=' ,$lastversion+1],['publish_status' ,'<>','deleted'],['createdby','=',Auth::user() ->id]])
                         ->get();

        if ($skills->count()<>  0)  return true;

        else  return false;

    }
    public function contains(Skillcategory $skillcategory){
        return $this->skillcategory->where('skill_category_id',$skillcategory->id);
    }
    // get the user who updated this skill category
    public function getusername_updateby()
    {
        $user=User::where ( 'id',$this->updatedby )->first();
        if ($user)
            return  $user->name;

        return "";
    }

    //get the user who created this skill category
    public function getusername_createdby()
    {
        $user=User::where ( 'id',$this->createdby )->first();

        if ($user)
            return  $user->name;

        return "";
    }
    // ----------------------------------------------------------------------

    //get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    //get updated_at Attribute
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
