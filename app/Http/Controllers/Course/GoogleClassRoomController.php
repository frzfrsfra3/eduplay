<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Userexamanswer;
use App\Models\GoogleClassroom;
use App\Models\GoogleclassExercises;
use App\Models\GoogleclassLearners;
use App\Models\GoogleclassExams;
use App\Models\User;
use App\Models\Exerciseset;
use App\Events\InviteLearner;
use App\Events\UserRegistered;
use App\Mail\ImportGoogleStudent;
USE Carbon\Carbon;
use Lang;

class GoogleClassRoomController extends Controller
{

    public function __construct() {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        $this->middleware('auth');
    }

   /**
     * Display Google classroom detail
     */
    public function googleClassroomDetails($classid){
      $user = Auth::user();
      $googleclass =  GoogleClassroom::where('classid','=',$classid)->with('teacher')->firstOrFail();

      if ($googleclass->user_id == $user->id) {
        return view('courseclasses.google_class.detail',compact('googleclass'));
      } else {
        $learner = GoogleclassLearners::with('googleClassroom')->where('user_id', '=', $user->id)->where('class_id', '=', $classid)->first();
        $exams = $googleclass->exams()->get();
        foreach ($exams as $key => $value) {
            if ($value->isavailable == 'N') {
                unset($exams[$key]);
            }
        }
        return view('courseclasses.google_class.learnerclass', compact('googleclass', 'learner', 'user', 'exams'));
      }
    }

    /**
     * Update imported class in database.
     */
    public function classroomUpdate(Request $request,$classid){
      $googleclass =  GoogleClassroom::where('classid','=',$classid)->where('user_id','=',Auth::user()->id)->firstOrFail();
      $googleclass->fill($request->all());
      $googleclass->save();

      return redirect()->route('google.classroom.details',[$classid])->with('success_message',  Lang::get('controller.import_success'));
    }

  /**
   * Import google class student as site user. 
  * If a user has registered before using social auth, return the user
  * else, create a new user object.
  */
  public function importClassStudent(Request $request,$class_id){
      $user = $request->all();
      try {
        $authUser = User::where('email', $user['emailAddress'])->first();
        $googleclass =  GoogleClassroom::where('id','=',$class_id)->first();
        $classURL = route('google.classroom.details',[$googleclass['classid']]);

        if ($authUser) {
          return $this->invitelearner($authUser, $class_id);
        }

        if (isset($user['photoUrl']) && !empty($user['photoUrl'])) {
            $picture = 'https:'.$user['photoUrl'];
        } else {
            $picture = 'profile_img.jpg';
        }
        
        $rendompassword = str_random(8);

        $newuser = User::create([
            'name' => $user['name']['fullName'],
            'email' => $user['emailAddress'],
            'password' => Hash::make($rendompassword),
            'provider' => 'google',
            'provider_id' => $user['id'],
            'user_image' => $picture,
            'is_email_active' => 0,
        ]);

        userregistred($newuser);
        event(new UserRegistered($newuser));

        $sender = Auth::user();
        //Inter classlearner table entry.
        $this->invitelearner($newuser, $class_id);
        // Send Emails to registered parent's & child for courseclass
        Mail::to($user['emailAddress'])->send(new ImportGoogleStudent($rendompassword,$sender ,$newuser,$classURL));
        Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $user['emailAddress'] );
        Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
    
        if (Mail::failures()) {
            return 'mail_not_sent';
        } else {
            return 'mail_sent';
        }

    } catch (Exception $exception) {
        Storage::disk('local')->append('faceloginerror.txt', 'facebook');
    }
  }

   /**
     * teacher invites learner to the class and throw an Event
     */
    public function invitelearner($user, $class_id) {
      $user_id = $user->id;
      
      $course = GoogleClassroom::findorfail($class_id);

      $classLearner = GoogleclassLearners::where('user_id','=',$user_id)->where('class_id','=',$class_id)->first();

      if($classLearner){
        return 'already_user';
      } else {
        $invitelearner = New GoogleclassLearners();
        $invitelearner->user_id = $user_id;
        $invitelearner->class_id = $class_id;
        $invitelearner->googleclassid = $course->classid;
        $invitelearner->status = 'Enrolled';
        $invitelearner->save();

        return 'added_on_class';
      }

  }

    /**
      * Remove lerner from class.
     */
    public function removeGoogleClassLearner() {
      $classLearner = GoogleclassLearners::where('user_id', '=', request('user_id'))->where('googleclassid', '=', request('class_id'))->delete();
      if ($classLearner) {
          $message = 'Success';
      } else {
          $message = 'Error';
      }
      return response()->json($message);
  }

   /**
     * remove exercise from this class
     */
    public function removeexercise($class_id, $exercise_id) {
      try {
          $classexercise = GoogleclassExercises::where('class_id', '=', $class_id)->where('exercise_id', '=', $exercise_id)->first();
          if ($classexercise) {
              $classexercise->delete();
          }
          $googleclass = GoogleClassroom::findorfail($class_id);
          $myexercise = Exerciseset::findorfail($exercise_id);
          return view('courseclasses.google_class.exercise', compact('myexercise', 'googleclass'));
      }
      catch(Exception $exception) {
          return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
      }
    }

   /**
   * addexamtoclass ( New OR exist to class ) -Prepare by WC
   */
    public function addexamtoclass($id) {
      $user = Auth::user();
      $myexams = $user->myexams()->where('isavailable', 'Y')->get();
      $googleclass = GoogleClassroom::findorfail($id);
      $courseclassexams = $googleclass->exams()->get();
      $myexams = $myexams->diff($courseclassexams);
      $myexams->unique();

      return view('courseclasses.google_class.addexamtoclass')->with(['myexams' => $myexams, 'classId' => $id]);
    }

     /**
     * add exam to this class
     */
    public function addexam($class_id, Request $request) {
        $courseclass = GoogleClassroom::findorfail($class_id);
      
        foreach ($request->exam as $key => $dates) {
            $exam_id = $key;
            $exam_start_date = Carbon::parse($dates['startDate'])->format('Y-m-d H:m:s');
            $exam_end_date = Carbon::parse($dates['endDate'])->format('Y-m-d H:m:s');
            $classexam = new GoogleclassExams;
            $classexam->class_id = $class_id;
            $classexam->exam_id = $exam_id;
            $classexam->exam_start_date = $exam_start_date;
            $classexam->exam_end_date = $exam_end_date;
            $classexam->save();
        }
      
        return redirect()->route('google.classroom.details', ['id' => $courseclass->classid, '#assignments'])->with('success_message', 'Exam added in your google class !!');
  }

    /**
     * remove exam from this class if not yet taken
     */
    public function removeexam($classId, $classexam_id) {
      try {

          $userexamanswer = Userexamanswer::where('exam_id', $classexam_id)->first();

          if(empty($userexamanswer)){
            $classexams = GoogleclassExams::where('class_id', $classId)->where('exam_id', $classexam_id)->first();
            $classexams->delete();
            
            //  event (new ExerciseSetAdded( $courseclass));
            return 'success';
          } else {
            return 'useranswer';
          }
          
      }
      catch(Exception $exception) {
          Storage::disk('local')->append('exam-calss-delete.txt', $exception);
          return 'fail';
      }
  }

}
