<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/17/2018
 * Time: 1:01 PM
 */

/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Courseclass;
use App\Models\Exercisesetbuyer;
use App\Models\Exerciseset;
use App\Models\Question;
use App\Models\Skillcategory;
use App\Models\Skill;
use App\Models\User;
use App\Models\Userinterest;
use Illuminate\Support\Collection;
use App\Models\Discipline;
use App\Models\Classlearner;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp;
use File;
use Mustache_Engine;
use Response;
use Illuminate\Support\Facades\Route;

class APIExercises extends Controller
{

	public function getexersises  ()
	{

		$data = array();
		$data['topic_id'] = Input::get('topic_id');
		$data['language_id'] = Input::get ('language_id');
		$data['discipline_id'] = Input::get ('discipline_id');
		$data['grade_id'] = Input::get ('grade_id');
		$data['teachername'] = Input::get ('teachername');  //optional parameter
		$data['classname'] = Input::get ('classname');  //optional parameter
		$data['user_token'] = Input::get ('user_token');  //optional parameter
		$validator = $this->exersisevalidator1 ($data);
		
		//This function is used for check validation.
		if ($validator->fails ()) {
			$messages = $validator->errors ()->first ();
			$responce = $this->rendererrorresponse ($messages);
			return json_encode ($responce);

		}
		
		//This is for use no teacher name and no class name entered.
		if (strlen ($data['teachername']) == 0 && strlen ($data['classname']) == 0) {
			echo $this->getlist ($data, 1);
			return;
		}
  
		//This is for use teacher name available class name not entered.
		if (strlen ($data['teachername']) != 0 && strlen ($data['classname']) == 0) {
			$teacher = User::where ('name', '=', $data['teachername'])->first ();
			if ($teacher) { 
				//Call get Exercises function.
				$exersiseset = $this->getExercisesData($data,$teacher->id);

				if ($exersiseset->count () == 0) {
						echo $this->getlist ($data, 2);
						return;
					} else {
						foreach ($exersiseset as $exersise) {
								$this->addteachername ($exersise);
						}
					//   $this->addteachername($exersiseset);
						$responce = $this->renderresponse ($exersiseset, "Success list of exercises ");
						return json_encode ($responce);
					}
				} else {
						echo $this->getlist ($data, 3);
						return;
				}


		}

		//This function is using for no teacher available and class name available.
		if (strlen ($data['teachername']) == 0 && strlen ($data['classname']) != 0) {
			$class = Courseclass::where ('class_name', '=', $data['classname'])->first ();
				if ($class) {
						$exersiseset = $class->exercises ();
						$exersiseset = $exersiseset->where('topic_id', '=', $data['topic_id'])->where ('discipline_id', '=', $data['discipline_id'])->where ('grade_id', '=', $data['grade_id'])
								->where ('language_id', '=', $data['language_id'])->where ('price', '=', 0)->get ();

						foreach ($exersiseset as $exersise) {
								$this->addteachername ($exersise);
						}

						$responce = $this->renderresponse ($exersiseset, "Success list of exercises ");
						return json_encode ($responce);
				} else {
						echo $this->getlist ($data, 4);

						return;
				}
			}

		//This function is using for no teacher available and no class name available.
		if (strlen ($data['teachername']) != 0 && strlen ($data['classname']) != 0) {
      $class = Courseclass::where ('class_name', '=', $data['classname'])->first ();
      if (!empty($class)) {
            // Class Exercise and exams.
            //Check user's learner or not.
            if($data['user_token']){
              $user = User::where('remember_token','=',$data['user_token'])->first();
   
              //Check learner role.
              if(!empty($user)){
                $classlearner = Classlearner::where('user_id','=',$user->id)->where('class_id','=',$class->id)->first();
                if(!empty($classlearner)){
                  $resultData = [];
                  $exam = $class->exams()->where('examtype','!=','test')->get();
                  $exersiseset = $class->exercises ()->where('topic_id', '=', $data['topic_id'])
                                ->where ('language_id', '=', $data['language_id'])->where ('price', '=', 0)->get();
    
                  $resultData['exam'] = $exam;          
                  $teacher = User::where ('name', '=', $data['teachername'])->first ();
                  
                  if (!empty($teacher)) {
                    $exersiseset = $exersiseset->where ('createdby', '=', $teacher->id);
                    
                    if ($exersiseset->count()<>0) {
                      foreach ($exersiseset as $exersise) {
                        $this->addteachername ($exersise);
                      }
    
                      $resultData['exersiseset'] = $exersiseset;
                      $responce = $this->renderresponse ($resultData, "Success list of class exercises and exam");
                      return json_encode ($responce);
        
                    } else {
                      echo $this->getlist ($data, 5);
        
                      return;
                      }
                  }	else {
                      if ($exersiseset->count()<>0) {
                        foreach ($exersiseset as $exersise) {
                            $this->addteachername ($exersise);
                        }
                        $responce = $this->renderresponse_partofselection ($exersiseset, "Teacher name not found ,   list of exercises for the class : ".$class->class_name);
                        return json_encode ($responce);
                      }
                      else {
                      echo $this->getlist ($data, 5);
        
                      return;
                      }
                  }
  
                } else {
                  $responce = $this->renderresponse_partofselection ([], "Please enroll in ".$class->class_name." class first");
                  return json_encode ($responce);
                }
              } else {
                $responce = $this->renderresponse_partofselection ([], "User not found");
                return json_encode ($responce);
              }
            }		
				} else {
						echo $this->getlist ($data, 4);

						return;
				}
		}
  }
  
  /**
   * 
   * Get Class exercise.
   */
  public function getclassexersises(){

    $data = array();
		$data['topic_id'] = Input::get('topic_id');
		$data['language_id'] = Input::get ('language_id');
		$data['discipline_id'] = Input::get ('discipline_id');
		$data['grade_id'] = Input::get ('grade_id');
		$data['teachername'] = Input::get ('teachername');  //optional parameter
		$data['classname'] = Input::get ('classname');  //optional parameter
		$data['user_token'] = Input::get ('user_token');  //optional parameter
		$validator = $this->exersisevalidator1 ($data);
		
		//This function is used for check validation.
		if ($validator->fails ()) {
			$messages = $validator->errors ()->first ();
			$responce = $this->rendererrorresponse ($messages);
			return json_encode ($responce);

    }
    
      // This function is using for no discipline and no grade but teacher available and class name available and.
      if($data['discipline_id'] == null && $data['grade_id'] == null && strlen ($data['teachername']) != 0 && strlen ($data['classname']) != 0) {
        $class = Courseclass::where ('class_name', '=', $data['classname'])->first();
        if ($class) {
            //Check user's learner or not.
            if($data['user_token']){
              $user = User::where('remember_token','=',$data['user_token'])->first();
            } else {
              $user = [];
            }
            //Check learner role.
            if(!empty($user) && $user->hasRole('Learner')){

              $resultData = [];
              $exam = $class->exams()->where('examtype','!=','test')->get();
                            
              $exersiseset = $class->exercises ()->where('topic_id', '=', $data['topic_id'])
                            ->where ('language_id', '=', $data['language_id'])->where ('price', '=', 0)->get();

              $resultData['exam'] = $exam;
              $resultData['exersiseset'] = $exersiseset;
              
              $responce = $this->renderresponse ($resultData, "Success list of class exercises and exam");
              return json_encode ($responce);


            } else {
              $responce = $this->renderresponse_partofselection ([], "Please enroll in ".$class->class_name." class first");
              return json_encode ($responce);
            }
        } else {
          echo $this->getlist ($data, 4);

          return;
      }
    }
  }

	/**
	 * Add Teacher name.
	 */
	private function addteachername(Exerciseset $exersise ){

			$userid=$exersise->createdby;
			$user=User::where('id' , '=' ,$userid)->first();
			$exersise['teachername']=$user->name;

		return;

	}

	/**
	 * Geting list as per the type passing.
	 */
	private function getlist ($data , $type ) {

			// $exersiseset=Exerciseset::where('discipline_id' , '=' ,  $data['discipline_id'])->where('grade_id','=', $data['grade_id'] )
			//     ->where('language_id' , '=' ,$data['language_id'])->where('price' ,  '=' ,0) ->where ('publish_status','=' ,'public')
			//    ->get();

			$exersiseset = $this->getExercisesData($data);        

			if ($exersiseset->count()==0) {
					$messages = '101, no exercises for your selection';
					$responce = $this->rendererrorresponse($messages);
					return  json_encode ($responce);

			} else {
				foreach ($exersiseset as $exersise) {
						$this->addteachername($exersise);
				}
				//Set response data by type
				if ($type==1) {
						$responce = $this->renderresponse ($exersiseset ,"Success list of exercises");
				} elseif ($type==2) {
						$responce = $this->renderresponse_partofselection ($exersiseset ,"Teacher name not found ,  proposed exercises :");
				} elseif ($type==3) {
						$responce = $this->renderresponse_partofselection ($exersiseset ,"Teacher name not found ,   proposed exercises : ");
				}	elseif ($type==4) {
						$responce = $this->renderresponse_partofselection ($exersiseset ,"Class name not found ,  proposed exercises :");
				} elseif ($type==5) {
						$responce = $this->renderresponse_partofselection ($exersiseset ,"Teacher or Class name name not found ,   proposed exercises : ");
				}
					return json_encode( $responce);
			}
	}

	/**
	 * Get Exercise Data with topic_id, discipline_id, grade_id, language_id,
	 * 
	 */
	public function getExercisesData($data,$teacherId = null){
			$exersiseset = Exerciseset::where ('topic_id', '=', $data['topic_id']);
			if($data['discipline_id'] != ''){
					$exersiseset->where ('discipline_id', '=', $data['discipline_id']);
			}
			if($data['grade_id'] != ''){
					$exersiseset->where ('grade_id', '=', $data['grade_id']);
			}

			$exersiseset->where ('language_id', '=', $data['language_id'])
									->where ('price', '=', 0)->where ('publish_status', '=', 'public');

			if($teacherId !== null){
				$exersiseset->where ('createdby', '=', $teacherId);
			}
			return $exersiseset->get();
	}

	/**
	 * Validation function
	 * 
	 */
	protected function exersisevalidator1 (array $data)
	{
			return Validator::make (
					$data,
					[
						'topic_id'=>'required|exists:topics,id',
						'discipline_id'=>'nullable|exists:disciplines,id',
						'grade_id'=>'nullable|numeric|exists:grades,id',
						'language_id' => 'required|exists:languages,id',
						'teachername'=>'nullable|string|min:1|max:500',
						'classname'=>'nullable|string|min:1|max:500',
						'user_token'=>'nullable|string|min:1|max:500',

					], $this->messagevalidation ()
			);
	}

	/**
	 * 
	 *Validation messages. 
	 */
	private function messagevalidation ()
	{

			return $messages = array(
				'topic_id.required' => '101:Empty topic id.',
				'topic_id.exists' =>'101: Topic not exist',
				'discipline_id.exists' =>'101: Discipline not exist',
				'grade_id.exists' =>  '101: grade id is not existing',
				'language_id.required' => '101:Empty language id.',
				'language_id.exists' =>  '101: language id is not existing',
				'teachername.max'=>'101:the teacher name passed 500 characters ',
				'classname.max'=>'101:the class name passed 500 characters ',
				'user_token.max'=>'101:the user token passed 500 characters ',
			);

	}

	/**
	 * Set Render Error response.
	 */
	private function rendererrorresponse($message)

	{
			$data=array();
			$errorid=substr($message, 0, 3);
			$errortext=substr($message, 4);
			$response=array();
			$response['status']=$errorid;
			$response['message']=$errortext;
			$response['data']=$data;
			return $response;
  }
  
  /**
   * 
   * Get Skill categories by exercises.
   *
   */

   public function getSkillCategories(Request $request){
      $ids = explode(",",$request->exercise_id);

      $exercisesets = Exerciseset::whereIn('id',$ids)->get();

      $skillCatIds = [];
      foreach($exercisesets as $exercise){
          $skillCategories = $exercise->question->where('skill_id','!=',null)->where('skillcategory_id','!=',null)->groupby('skillcategory_id')->all();
          
          foreach($skillCategories as $key => $skillCat){

            array_push($skillCatIds,$key);
          }
      }

      $associatedSkillCats = Skillcategory::whereIn('id',$skillCatIds)->get();

      // $resultData = [];
      // $resultData['skill_categories'] = $associatedSkillCats;
      // $resultData['exercise_ids'] = $ids;

      if(count($associatedSkillCats) > 0){
        $message = 'Success list of skill-categories.';
        $responce = $this->renderresponse($associatedSkillCats , $message);
      } else {
        $message = 'No skill category for selection.';
        $responce = $this->renderresponse_noSkillFound($associatedSkillCats , $message);
      }
      return json_encode ($responce);
   }

   /**
    * Get skill by skill categories. 
    *
    */
   public function getSkills(Request $request){

    $skillCateIds = explode(",",$request->skill_category_id);
    $exerciseIds = explode(",",$request->exercise_id);

    $questions = Question::where('skill_id','!=',null)->whereIn('skillcategory_id', $skillCateIds)
                          ->whereIn('exercise_id', $exerciseIds)->groupby('skill_id')->get();

    $skillIds = [];
    // $exerciseIds = [];

    foreach($questions as $question){
       array_push($skillIds,$question->skill_id);

      //  if(!in_array($question->exercise_id,$exerciseIds)){
        //  array_push($exerciseIds,$question->exercise_id);
      //  }
    }
    
    $skills = Skill::whereIn('id',$skillIds)->get();
    // $resultData = [];
    // $resultData['skills'] = $skills;
    // $resultData['exercise_ids'] = $exerciseIds;
    if(count($skills) > 0){
      $message = 'Success list of skills.';
      $responce = $this->renderresponse($skills , $message);  
    } else {
      $message = 'No skill for your selection.';
      $responce = $this->renderresponse_noSkillFound($skills , $message);
    }

    return json_encode ($responce);

   }

	/**
	* Set Render success response.
	*/
	private function renderresponse($data , $message)

	{

			$response=array();
			$response['status']="1";
			$response['message']= $message ;
			$response['data']=$data;
			return $response;

	}

	/**
	 * Set render response part of selection.
	 * 
	 */
	private function renderresponse_partofselection($data , $message)

	{
			$response=array();
			$response['status']="102";
			$response['message']= $message ;
			$response['data']=$data;
			return $response;

  }
  
  	/**
	 * Set render response no skill and skill categories found.
	 * 
	 */
	private function renderresponse_noSkillFound($data , $message)

	{
			$response=array();
			$response['status']="101";
			$response['message']= $message ;
			$response['data']=$data;
			return $response;

	}
}