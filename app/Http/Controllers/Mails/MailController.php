<?php
namespace App\Http\Controllers\Mails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExerciseSetShare;
use App\Mail\AssignmentShare;
use App\Mail\SendReportToTeachers;
use App\Jobs\SendEmailJob;
use App\Jobs\SendEmailForLearner;
use App\Http\Traits\AddXppoint;
use Illuminate\Support\Facades\Auth;
use App\Models\Exerciseset;
use App\Models\Question;
use App\Models\Skillcategory;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class MailController extends Controller {

    use AddXppoint;
    /**
     * Send emails for exercisesets
     * 
     * param Illuminate\Http\Request $request
     * return Redirect
     */
    public function mailSendForExerciseset() {
        // For xppoints Badges
        $this->add_xp_point (Auth::user ()->id, 'shareexerciseset');
        $email = request('email');
        
        $expiresAt = Carbon::now()->addDay(3);
        $share_id = uniqid();
        Cache::put($share_id , true, $expiresAt );
        $url = request('url') . "?share_id=" . $share_id;


        // parsing url to get assignment id 
        // this method is bad but we are forced to use it for using time.
        $state1 = explode('practice/' , request('url'));
        $state2 = $state1[1];
        $id = intval($state2);

        Mail::to($email)->send(new ExerciseSetShare($url, $email , $id));
        Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $email );
        Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
    
        if (Mail::failures()) {
            $msg = 'Mail sent unsuccessfully!';
        } else {
            $msg = 'Mail sent successfully!';
        }
        return redirect()->route('exercisesets.exerciseset.private')->with('success_message', $msg);
    }

    public function mailSendForAssignment() {
      // For xppoints Badges
      $this->add_xp_point (Auth::user ()->id, 'shareexerciseset');
      $email = request('email');

      $expiresAt = Carbon::now()->addDay(3);
      $share_id = uniqid();
      Cache::put($share_id , true, $expiresAt );
      $url = request('url') . "?share_id=" . $share_id;

      // parsing url to get assignment id 
      $state1 = explode('takeexam/' , $url);
      $state2 = explode('/' , $state1[1]);
      $id = $state2[0];
      //return "url is: " . $url . " and the id is " .  $id;

      //return "url:" . $url . "\n" . "Cached:" . Cache::get($share_id);


      Mail::to($email)->send(new AssignmentShare($url, $email , $id));
      Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $email );
      Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
  
      if (Mail::failures()) {
          $msg = 'Mail sent unsuccessfully!';
      } else {
          $msg = 'Mail sent successfully!';
      }
      return redirect()->route('exams.exam.index')->with('success_message', $msg);
  }

    /**
     * Display the specified exerciseset from mail all guest.
     */
    public function show($id , $ispublic=null)
    {
        $exerciseset = Exerciseset::with('discipline','grade','language')->findOrFail($id);
        $userrate = $this->collectOneSetRatingsWithUser($exerciseset);
        $questions = Question::with('skill','skillcategory','exercise','answeroptions')->where('exercise_id','=',$id)->paginate(25);
        $skill_categories = SkillCategory::where('discipline_id','=',$exerciseset->discipline_id)->get();
        //Skills related curriculum and question count.
        if(!empty($exerciseset->discipline)){
            $associatedSkills = Skillcategory::where('discipline_id','=',$exerciseset->discipline->id)
                            ->with('skill')->get();
        } else {
            $associatedSkills = [];
        }

        if(Auth::user()){
            $exercisesets = Exerciseset::where('id','!=',$id)->where('createdby', '=', Auth::user()->id)->get();
        } else {
            $exercisesets = [];
        }

        return view('eduplaycloud.users.private-library.guest-exercise-show', compact('exerciseset', 'userrate','questions',
                    'exercisesets','skill_categories','associatedSkills'));
    }

    /**
     * Send mail notification check by each user.
     */
    public function checkInThreeDayUserLoggedIn(){
      $users = User::get();
      foreach($users as $user){

        $date1 = Carbon::now();
        $date2 = $user->lastloggedon;

        $diff = abs(strtotime($date2) - strtotime($date1));

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        if($days > 3){
          if($user->hasRole('Parent')){
              // $this->LearnerReportForTeacher($user,$date2,$date1);
            } else if($user->hasRole('Teacher')){
              // $this->LearnerReportForTeacher($user,$date2,$date1);
            } else {
              $this->LearnerReport($user);
          }
        }
      }
    }

    /**
     * Send mail notification for teachers.
     * 
     */
    public function LearnerReportForTeacher($user,$date2,$date1){
      $students = User::where('parentmail','=',$user->email)->get();
      $fromDate = date('F d \\, Y', strtotime($date2)); 
      $toDate = date('F d \\, Y', strtotime($date1));
      $url = route('reports');


      $date = Carbon::parse($user->dob)->format('Y');

      if ($this->AgeCounting($date, 13)) {
        dispatch(new SendEmailJob($user,$url,$students,$fromDate,$toDate));
      }

    }

    /**
     * Send Learner report.
     * 
     */
    public function LearnerReport($user){

      $date = Carbon::parse($user->dob)->format('Y');
      $url = route('reports');

      if ($this->AgeCounting($date, 13)) {
        dispatch(new SendEmailForLearner($user,$url));
      } 
    }

     /**
     *
     * Calclulate  Age limit.
     *
     * param int $childYear
     * param int $minAge
     * return Response
     */
    protected function AgeCounting($childYear, $minAge) {
      // or the same using Carbon:
      $currentYear = Carbon::now()->year;
      $diff = (int)$currentYear - (int)$childYear;
      if ($diff >= $minAge) { // Check if diffrence is greater then min age
          return true;
      } else {
          return false;
      }
      // return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
  }

}
