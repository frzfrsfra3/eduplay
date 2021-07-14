<?php

namespace App\React\Course;

use App\Events\EnrollRequested;
use App\Models\Classexam;
use App\Models\Classexercise;
use App\Models\Exam;
use App\Models\Exerciseset;
use App\Models\Grade;
use App\Models\Language;
use App\Models\Discipline;
use App\Models\Curriculum;
use App\Models\Classlearner;
use App\Models\Courseclass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\Actiontaken;
use App\Events\ClassCreated;
use App\Events\ExamAdded;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Events\ExerciseSetAdded;
use App\Events\InviteLearner;
use App\Http\Controllers\Course\Input;
USE Carbon\Carbon;
use App\Http\Traits\AddXppoint;

//use Carbon;
use Exception;

class CourseclassesController extends Controller
{
    use AddXppoint;

    public function __construct ()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        $this->middleware ('auth');
        $this->photos_path = public_path ('/images');
    }

    /**
     * list all courses that are published
     */
    public function index (Request $request)
    {

        $paginationcount = 12;
        if (isset($_GET['searchkey'])) {
            $name = $_GET['searchkey'];
        } else {
            $name = '';
        }
        $courseclasses = Courseclass::with ('discipline', 'grade', 'language')
            ->where ([['isavailable', 'like', 'y'], ['class_name', 'like', '%' . $name . '%']])
            ->orwhere ([['isavailable', 'like', 'y'], ['class_description', 'like', '%' . $name . '%']])->paginate ($paginationcount);

        if ($request->ajax ()) {

            $view = view ('courseclasses.classes', compact ('courseclasses'))->render ();

            return response ()->json (['html' => $view]);
            //  return response()->json(['html'=>$id]);
        }

        return view ('courseclasses.index', compact ('courseclasses', 'paginationcount'));

    }

    /**
     * list mycourses only
     */
    public function listmyclasses ()
    {
        $user = Auth::user ();

        $teacherclasses = Courseclass::where ('teacher_userid', '=', $user->id)->get ();
        $enroledclasses = $user->enrolledclasses ()->where ([['isavailable', '=', 'Y'], ['status', '=', 'Accepted']])->get ();

        return view ('courseclasses.myclasses', compact ('teacherclasses', 'enroledclasses'));
    }

    /**
     * Show the form for creating a new courseclass.
     **/
    public function create ()
    {


        if (Auth::user ()->can ('create', Courseclass::class)) {
            $languages = Language::pluck ('language', 'id')->all ();
            $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();
            $grades = Grade::pluck ('grade_name', 'id')->all ();

            return view ('courseclasses.create', compact ('languages', 'disciplines', 'grades'));
        } else {
            return view ('unauthorized');
        }
    }

    /**
     * Store a new courseclass in the storage.
     */
    public function store (Request $request)
    {

        try {
            //    dd($request);

            $path = $this->saveimage ($request);
            $data = $this->getData ($request);

            $data['start_date'] = date ('Y-m-d', strtotime ($data['start_date']));
            $data['end_date'] = date ('Y-m-d', strtotime ($data['end_date']));
            if ($path == '0') {
                $data['iconurl'] = '';

            } else {
                $data['iconurl'] = $path;

            }


            $newclass = Courseclass::create ($data);
            event (new ClassCreated($newclass));
            $this->add_xp_point (Auth::user ()->id, 'createclass');


            return redirect ()->route ('courseclasses.courseclass.show', $newclass->id)
                ->with ('success_message', 'Courseclass was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified courseclass.
     */
    public function show ($id)
    {
        $user = Auth::user ();
        $courseclass = Courseclass::findOrFail ($id);
        if ($user->can ('update', $courseclass))
            return view ('courseclasses.show', compact ('courseclass'));

        else

            $learner = Classlearner::with ('courseclass')->where ('user_id', '=', $user->id)->where ('class_id', '=', $id)->first ();


        return view ('courseclasses.learnerclass', compact ('courseclass', 'learner'));


    }

    /**
     * Show the form for editing the specified courseclass.
     */
    public function edit ($id)
    {
        $courseclass = Courseclass::findOrFail ($id);
        $classdiscipline = $courseclass->discipline ()->first ();
        $languages = Language::pluck ('language', 'id')->all ();
        $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();
        $grades = Grade::where ('curriculum_gradelist_id', '=', $classdiscipline->curriculum_gradelist_id)->get ()->pluck ('grade_name', 'id');

        return view ('courseclasses.edit', compact ('courseclass', 'languages', 'disciplines', 'grades'));
    }

    /**
     * Update the specified courseclass in the storage.
     */
    public function update ($id, Request $request)
    {
        try {

            $path = $this->saveimage ($request);
            $data = $this->getData ($request);
            $data['start_date'] = date ('Y-m-d', strtotime ($data['start_date']));
            $data['end_date'] = date ('Y-m-d', strtotime ($data['end_date']));
            if ($path != '0') $data['iconurl'] = $path;


            $courseclass = Courseclass::findOrFail ($id);
            $courseclass->update ($data);

            return redirect ()->route ('courseclasses.courseclass.show', $courseclass->id)
                ->with ('success_message', 'Courseclass was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    private function saveimage (Request $request)
    {

        if ($request->file ('image') != null) {

            $path = Storage::disk ('images')->putFile ('', $request->file ('image'));

            if (!is_dir ($this->photos_path)) {
                mkdir ($this->photos_path, 0777);
            }
            $img = Image::make ('Images\\' . $path);
            $img->resize (300, 200);
            $img->save ('assets\images\\' . $path);
            $image_path = 'Images\\' . $path;  // Value is not URL but directory file path

            if (File::exists ($image_path)) {
                File::delete ('Images\\' . $path);
            }


            return $path;
        }
        return '0';

    }


    /**
     * Remove the specified courseclass from the storage.
     */
    public function destroy ($id)
    {
        try {
            $courseclass = Courseclass::findOrFail ($id);

            $courseclass->delete ();

            return redirect ()->route ('courseclasses.courseclass.index')
                ->with ('success_message', 'Courseclass was successfully deleted!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    public function requestjpoin ($classid, $guest = null)
    {
       try {
            $this->middleware ('auth');


            $course = Courseclass::findorfail ($classid);
            $data = [
                'message' => trans ('messages.youarelareadyinclass')
            ];
            $useralreadyexist = Classlearner::where ('class_id', '=', $classid)->where ('user_id', '=', Auth::user ()->id)->first ();
            if (!$useralreadyexist) {
                $newrequest = new Classlearner;
                $newrequest->class_id = $classid;
                $newrequest->user_id = Auth::user ()->id;
                $newrequest->status = 'pending';
                $newrequest->joindate = Carbon::now ();
                $newrequest->save ();
                event (new EnrollRequested($course));


                $data = [
                    'message' => trans ('messages.thanksrequestjointoclass')
                ];
            }
            if ($guest == 1) {
                return redirect ()->route ('courseclasses.courseclass.index');
            }
            return response ()->json ($data, 200);
       } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    public function addlearner (Request $request, $class_id)
    {
        $courseclass = Courseclass::findorfail ($class_id);

        $name = $request->name;
        if (strlen ($name) > 0) {
            $learner = $courseclass->learners;
            $enrollid = $learner->pluck ('id');
            $users = User::select ('id', 'name', 'user_image')->where ('name', 'like', '%' . $name . '%')->whereNotIn ('id', $enrollid)->get ();

        } else {
            $users = null;
        }


        return view ('classlearners.addlearners', compact ('courseclass', 'users'));
    }


    public function invitelearner (Request $request, $class_id)
    {
        $user_id = $request->user_id;
        $course = Courseclass::findorfail ($class_id);
        $invitelearner = New Classlearner();
        $invitelearner->user_id = $user_id;
        $invitelearner->class_id = $class_id;
        $invitelearner->status = 'Invited';
        $invitelearner->save ();
        event (new InviteLearner($user_id, $course));
        return ('yes');
    }


    public function accept ($id)
    {
        //accept a learner to a class
        try {
            $courselearner = Classlearner::findorfail ($id);
            if ($courselearner) {

                $courselearner->status = 'Accepted';
                $courselearner->joindate = Carbon::now ();
                $courselearner->save ();
                event (new Actiontaken("accepted", $courselearner));
                $course = Courseclass::findorfail ($courselearner->class_id);
                $learner = $course->learners ()->findorfail ($courselearner->user_id);

            }


            return view ('courseclasses.learner', compact ('learner'));

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    public function reject ($id)
    {

        //reject a learner to a class
        try {
            $courselearner = Classlearner::findorfail ($id);
            if ($courselearner) {

                $courselearner->status = 'Rejected';
                $courselearner->joindate = Carbon::now ();
                $courselearner->save ();
                event (new Actiontaken("rejected", $courselearner));
                $course = Courseclass::findorfail ($courselearner->class_id);
                $learner = $course->learners ()->findorfail ($courselearner->user_id);

            }

            return view ('courseclasses.learner', compact ('learner'));

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    public function addexercise ($class_id, $exercise_id)
    {
        try {
            $classexercise = new  Classexercise;
            $classexercise->class_id = $class_id;
            $classexercise->exercise_id = $exercise_id;
            $classexercise->save ();

            $courseclass = Courseclass::findorfail ($class_id);
            $myexercise = Exerciseset::findorfail ($exercise_id);
            event (new ExerciseSetAdded($courseclass));
            return view ('courseclasses.exercise', compact ('myexercise', 'courseclass'));

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }

    }

    public function addexam ($class_id, $exam_id, Request $request)
    {
        try {

            $courseclass = Courseclass::findorfail ($class_id);

            $data = $this->getExamDates ($request);
            $datestarted = \DateTime::createFromFormat ('D M d Y H:i:s e+', $data['start_date']); // Thu Nov 15 2012 00:00:00 GMT-0700 (Mountain Standard Time)
            $dateended = \DateTime::createFromFormat ('D M d Y H:i:s e+', $data['end_date']); // Thu Nov 15 2012 00:00:00 GMT-0700 (Mountain Standard Time)


            $age = Carbon::parse (session ('bday'))->age;
            $exam_start_date = Carbon::parse ($datestarted->format ('d/m/Y H:m:s'));
            $exam_end_date = Carbon::parse ($dateended->format ('d/m/Y H:m:s'));

            $classexam = new Classexam;
            $classexam->class_id = $class_id;
            $classexam->exam_id = $exam_id;
            $classexam->exam_start_date = $exam_start_date;
            $classexam->exam_end_date = $exam_end_date;
            $classexam->save ();

            $exam = Exam::where ('id', '=', $exam_id)->first ();
            $courseclass = Courseclass::findorfail ($class_id);

            event (new ExamAdded($courseclass, $exam));
            return view ('courseclasses.user-exams', compact ('courseclass'))->with ('error_date', '');
        } catch (Exception $exception) {
            Storage::disk ('local')->append ('exam-calss-eddod.txt', $exception);
            return view ('courseclasses.user-exams', compact ('courseclass'))->with ('error_date', 'error_date');

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }

    }

    public function removeexam ($classexam_id)
    {
        try {
            $classexams = Classexam::findorfail ($classexam_id);
            $classexams->delete ();
            //  event (new ExerciseSetAdded( $courseclass));
            return 'done';

        } catch (Exception $exception) {
            Storage::disk ('local')->append ('exam-calss-delete.txt', $exception);
            return 'error';
        }

    }


    public function removeexercise ($class_id, $exercise_id)
    {
        try {
            $classexercise = Classexercise::where ('class_id', '=', $class_id)->where ('exercise_id', '=', $exercise_id)->first ();
            if ($classexercise) {
                $classexercise->delete ();
            }
            $courseclass = Courseclass::findorfail ($class_id);
            $myexercise = Exerciseset::findorfail ($exercise_id);
            return view ('courseclasses.exercise', compact ('myexercise', 'courseclass'));

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }

    }

    public function isavailableclass ($class_id)
    {

        $class = Courseclass::findorfail ($class_id);
        if ($class) {
            $class->isavailable;
            if ($class->isavailable == 'Y') $class->isavailable = 'N';
            else $class->isavailable = 'Y';
            $class->save ();
        }

        return $class->isavailable;
    }

    public function myexercises ($class_id)
    {

        $courseclass = Courseclass::findorfail ($class_id);
        return view ('courseclasses.user-exercises', compact ('courseclass'));

    }

    public function myexams ($class_id)
    {

        $courseclass = Courseclass::findorfail ($class_id);
        return view ('courseclasses.user-exams', compact ('courseclass'))->with ('error_date', '');;

    }

    public function classexams ($class_id)
    {

        $courseclass = Courseclass::findorfail ($class_id);
        return view ('courseclasses.class_exams', compact ('courseclass'));;

    }

    /**
     * Get the request's data from the request.
     */
    protected function getData (Request $request)
    {
        $rules = [
            'class_name' => 'required|string|min:1|max:250',
            'class_description' => 'required',
            'language_id' => 'required|numeric|min:0|max:4294967295',
            'start_date' => 'nullable|string|min:0',
            'end_date' => 'nullable|string|min:0',
            'discipline_id' => 'nullable',
            'grade_id' => 'nullable',
            'teacher_userid' => 'required|numeric|min:1|max:2147483647',
            'isavailable' => 'required',
            'iconurl' => 'nullable',

        ];

        $data = $request->validate ($rules);

        return $data;
    }

    protected function getExamDates (Request $request)
    {
        $rules = [
            'start_date' => 'required',
            'end_date' => 'required',


        ];


        $data = $request->validate ($rules);

        return $data;
    }

}
