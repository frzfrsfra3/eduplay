<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Userexamscore;
use Illuminate\Support\Facades\Auth;
use Carbon;
use Log;
use Illuminate\Support\Facades\Storage;

class Exam extends Model
{
    protected $table = 'exams';
    protected $primaryKey = 'id';
    protected $fillable = [
                  'examtype',
                  'title',
                  'isavailable',
                  'skillcategory_id',
                  'skill_id',
                  'teacheruser_id',
                  'maxpoints'
              ];

    protected $dates = [];
    protected $casts = [];

    /**
     * Get the classes that have this exam
     */
    public function class()
    {
        return $this->belongsToMany('App\Models\Courseclass', 'classexams', 'exam_id', 'class_id');
    }

    /**
     * Get the skillcategories for this exam.
     */
    public function examSkillCategories()
    {
        return $this->belongsToMany('App\Models\Skillcategory', 'exam_skill_categories', 'exam_id', 'skill_category_id')->withTimestamps();
    }

    public function skillcategory()
    {
        return $this->belongsTo('App\Models\Skillcategory', 'skillcategory_id');
    }


    /**
     * Get the skill for this exam if any.
     */
    public function skill()
    {
        return $this->belongsTo('App\Models\Skill', 'skill_id');
    }

    /**
     * Get the Teacher for this exam.
     */
    public function teacheruser()
    {
        return $this->belongsTo('App\Models\User', 'teacheruser_id');
    }

    /**
     * Get the Exercises for the creation of this exam.
     */
    public function examExercises()
    {
        return $this->belongsToMany('App\Models\ExamExercises', 'exam_exercises', 'exam_id', 'exerciseset_id')->withTimestamps();
    }

    public function exam_exercisesets()
    {
        return $this->hasMany('App\Models\ExamExercises','exerciseset_id', 'id');
    }

    /**
     * Get the exam questions with their points.
     */
    public function examquestions()
    {
        return $this->belongsToMany('App\Models\Question', 'examquestions', 'exam_id', 'question_id')
            ->withPivot('points')->withPivot('sort_order');
    }

    /**
     * Get the Topics for this exam.
     */
    public function topics()
    {
        return $this->belongsToMany('App\Models\Topic', 'examtopics', 'exam_id', 'topic_id')
            ->withTimestamps();
    }

    public function newdiscipline()
    {
        return $this->belongsToMany('App\Models\Discipline', 'exam_disciplines', 'exam_id', 'discipline_id')->withTimestamps();
    }

    /**
     * Get all of the comments for the Exam
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function examDisciplines()
    {
        return $this->hasMany('App\Models\ExamDiscipline', 'exam_id', 'id');
    }



    /**

     */
    public function questionanswers()
    {
        return $this->belongsToMany('App\Models\Question', 'userexamanswers', 'exam_id', 'question_id')
            ->withPivot('classexam_id')->withPivot('question_id')->withPivot('iscorrect')->withPivot('teachermark');
    }

    /**
     */
    public function classexam ()
    {
        return $this->hasMany('App\Models\Classexam', 'exam_id');
    }

    public function class_id($exam_id)
    {
        if ( count(Classexam::where('exam_id' , $exam_id)->get()) > 0)
            return Classexam::where('exam_id' , $exam_id)->first()->class_id;
        else 
            return null;
    }

    /**
     * Get the Exam answers of all users (userexamanswer) given the exam_id.
     */
    public function userexamanswers()
    {
        return $this->hasMany('App\Models\Userexamanswer', 'exam_id', 'id');
    }

    /**
     * Get the Exam Score of all users (Userexamscore) given the exam_id -  Develop by WC
     */
    public function getUserExamScore()
    {
        return $this->hasMany('App\Models\Userexamscore', 'exam_id', 'id');
    }

    /**
     * Get the userexamscore for this model. --TODO Check strange relationship!!
     */
    public function userexamscore()
    {
        return $this->hasOne('App\Models\Userexamscore', 'exam_id', 'id');
    }

    /**
     * Get Exam Questions related to this question and given a skill ID -  Develop by WC
     */
    public function getQuestion()
    {
        return $this->hasMany('App\Models\Question','skill_id','skill_id');
    }

    /**
     * Get the class name given the class ID. --TODO Check Why is this  function in this model?
     */
    public function classname($classid)
    {
        $class = Courseclass::where('id', '=', $classid)->first();
        return $class->class_name;
    }

    /**
     * Get the points of a question given the question ID. --TODO Check Why is this function present in this Model?
     */
    public function questionmark($questionid)
    {
        $examquestion = $this->examquestions()->where('question_id', '=', $questionid)->first();
        if ($examquestion)
            return $examquestion->pivot->points;
        else
            return 0;
    }

    /**
     * Get created_at in array format
     */
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    //Get updated_at Attribute
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
