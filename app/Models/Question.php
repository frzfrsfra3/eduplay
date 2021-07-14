<?php

namespace App\Models;

use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Rap2hpoutre\FastExcel\FastExcel;
use Mustache_Engine;
use Auth;

class Question extends Model
{
    use Taggable;

    protected $table = 'questions';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'details',
                  'param',
                  'questiontype',
                  'skill_id',
                  'skillcategory_id',
                  'maxtime',
                  'mintime',
                  'exercise_id',
                  'size',
                  'difficultylevel',
                  'hint',
                  'tag',
                  'passage_id',
                  'json_details',

              ];

    protected $dates = [];
    protected $casts = [];

    /**
     * Get the skill of this question
     */
    public function skill()
    {
        return $this->belongsTo('App\Models\Skill','skill_id');
    }

    /**
     * Get the skillcategory of this question
     */
    public function skillcategory()
    {
        return $this->belongsTo('App\Models\Skillcategory','skillcategory_id');
    }

    /**
     * Get the exercise containing this question
     */
    public function exercise()
    {
        return $this->belongsTo('App\Models\Exerciseset','exercise_id');
    }

    /**
     * get the passage for the question if it exists
    */
    public function passage()
    {
        return $this->belongsTo('App\Models\Passage','passage_id');
    }

    /**
     * Get the examquestion this question is in --TODO Check this relation is hasMany
     */
    public function examquestion()
    {
        return $this->hasOne('App\Models\Examquestion','question_id','id');
    }

    /**
     * get the answer options of this question
     */
    public function answeroptions()
    {
        return $this->hasMany('App\Models\Answeroption','question_id','id');
    }
    public function apiansweroptions()
    {
        return $this->hasMany('App\Models\Answeroption','question_id','id')->inRandomOrder();
    }

    /**
     * Replace parameters in a parametrized question
     * return the question
     */
    public static function renderQuestion($id)
    {
        $item=array('demo');
        $question = Question::findorfail ($id);
        $param=$question->param;
        if (strlen($param)>0 && file_exists(public_path()."\assets\param\\".$param)){
            $file= public_path('assets/param/'.$param);
            $items = (new FastExcel)->import($file);
            $item = ($items->random());
            $m = new Mustache_Engine;
            $que = $m->render($question->details, $item);
        }
        else {
            $que=$question->details;
        }
        $excelques=array($que,$item);
        return $excelques;
    }

    /**
     * Render a parameterized question from its json details
     */
    public function paramRenderQuestion($user=null)
    {
        $userid = $this->exercise->createdby;
        $item=array();
        $question = $this;
        $json = json_decode($question->json_details);
        
        if($json->Parameters[0]->value->filename !== ""){
            // $param=$question->param;
            $param=$json->Parameters[0]->value->filename;
            
            if (strlen($param)>0 && file_exists(public_path("assets/eduplaycloud/upload/exercisesset/user-".$userid."/csv/".$param))){
                // $file=public_path('assets/param/'.$param);
                $file= public_path("assets/eduplaycloud/upload/exercisesset/user-".$userid."/csv/".$param);
                // $items = (new FastExcel)->import($file);
                // $items = (new FastExcel)->configureCsv(';', '#', '\n', 'gbk')->import($file);
                $header = null;
                $allRows = array();
                if (($handle = fopen($file, 'r')) !== false)
                {
                  while (($row = fgetcsv($handle, 1000, ',')) !== false)
                  {
                      if (!$header){

                        $header = $row;
                      } else {
                        
                        if(count($header) == count($row)){
                          $allRows[] = array_combine($header, $row);
                        }
                      }
                  }
                  fclose($handle);
                }
                
                //Skip blank rows in array
                // $allRows = [];

                // foreach($items as $iKey => $item){
                //     foreach($item as $key => $value){
                //         $itemKey = explode(",",$key);
                //         $itemValue = explode(",",$value);

                //         if(count($itemKey) == count($itemValue)){
                //             $array = array_combine($itemKey, $itemValue);
                //             array_push($allRows,$array);
                //         }
                //     }
                // }
               
                $rows = collect($allRows)->filter(function ($value, $key) {
                    if(!in_array("",$value)){
                        return $value;
                    }
                })->all();

                if(!empty($rows)){
                    $section = array_rand($rows);
                    $item = $rows[$section]; 
                } else {
                    $que=$question->json_details;
                }                
                // $item = collect($items)->filter(function ($value, $key) {
                //     if(!in_array("",$value)){
                //         return $value;
                //     }
                // })->random();
                // $item = ($rows->random());
    
                $a = array_map('trim', array_keys($item));
                $b = array_map('trim', $item);
                $stripResults = array_combine($a, $b);

                // dd($stripResults);
                // array_change_key_case($item,CASE_LOWER);
                $m = new Mustache_Engine;
                $que=$m->render($question->json_details, $stripResults);
                // dd($que);
            } else {
                $que=$question->json_details;
            }
        } else {
            $que=$question->json_details;
        }
        return $que;
    }

    public function getUserExamAnswere()
    {
        return $this->hasMany('App\Models\Userexamanswer','question_id','id')
            //->where('exam_id', $this->exam_id)
            ;
    }

    // Get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    // Get updated_at Attribute
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
