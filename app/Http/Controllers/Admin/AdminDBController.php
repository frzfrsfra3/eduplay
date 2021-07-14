<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Exerciseset;
use App\Models\Answeroption;
use App\Models\Question;

class AdminDBController extends Controller
{
  public function __construct()
  {
      //if trying to access this controller without being authenticated, it will ask him for authentication
      $this->middleware('auth');
  }

  /**
   * Display index page.
   */
  public function index(){
    return view('DB-cleaner');
  }

  /**
   * Delete answeroption that do not have parent question.
   */
  public function cleanAnswerOption(){
    $answerOptions = Answeroption::with('question')->get();

    foreach($answerOptions as $answers){
      if(empty($answers['question'])){
        $answers->delete();
      }
    }

    return redirect()->route('admin.db-clean')->with('success_message', 'Answeroption table was successfully cleaned!');
  }


  /**
   * 
   * 	it will delete questions that do not have parent exercise.
   * 
   */
  public function cleanQuestions(){
    $questions = Question::with('exercise')->get();

    foreach($questions as $question){
      if(empty($question['exercise'])){
        $question->delete();
      }
    }
    return redirect()->route('admin.db-clean')->with('success_message', 'Questions table was successfully cleaned!');
  }
  /**
   * 
   * it will delete exercise that do not have parent user.
   */
  public function cleanExercise(){
    $exercisesets = Exerciseset::with('owner')->get();
    foreach($exercisesets as $exerciseset){
      if(empty($exerciseset['owner'])){
        $exerciseset->delete();
      }
    } 
    return redirect()->route('admin.db-clean')->with('success_message', 'exercisesets table was successfully cleaned!');
  }
}
