<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rap2hpoutre\FastExcel\FastExcel;
use Mustache_Engine;
use Illuminate\Support\Facades\Auth;

class Answeroption extends Model
{
    // Should it be timestamped?
    public $timestamps = false;
    protected $table = 'answeroptions';
    protected $primaryKey = 'id';

    // Attributes that should be mass-assignable.
    protected $fillable = [
                  'question_id',
                  'answer_type',
                  'details',
                  'json_details',
                  'iscorrect',
                  'sort_order',
              ];

    // The attributes that should be mutated to dates.
    protected $dates = [];

    // The attributes that should be cast to native types.
    protected $casts = [
        'question_id' => 'int',
        'iscorrect' => 'bool',
        'sort_order' => 'int'
    ];

    public function renderAnswer($id, $aid)
    {
        $question = Question::findorfail($id);
        $param = $question->param;
        $answers = Answeroption::findorfail($aid);

        if (strlen($param) > 0) {
            $file = public_path('assets/param/'.$param);
            $items = (new FastExcel)->import($file);
            $item = ($items->random());
            $m = new Mustache_Engine;
            $ans = $m->render($answers->details, $item);
        } else {
            $ans = $answers->details;
        }

        return $ans;
    }


     // Get the question having this answeroption
    public function question()
    {
        return $this->belongsTo('App\Models\Question', 'question_id');
    }

    // Check if any question is the classexam passed as parameter has this answeroption as answer (for the Auth user)
    public function isanswered($classexam_id)
    {
        $user_id = Auth::user()->id;
        $examanswer = Userexamanswer::where('classexam_id', '=', $classexam_id)->where('user_id', '=',$user_id)->where('answer_id', '=', $this->id)->first();
        if ($examanswer ) return true;
        return false;
    }
}