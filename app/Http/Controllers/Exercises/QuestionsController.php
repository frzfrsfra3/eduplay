<?php

namespace App\Http\Controllers\Exercises;


use App\Models\Answeroption;
use App\Models\Passage;
use App\Models\Skill;
use App\Models\Question;
use App\Models\Exerciseset;
use Illuminate\Http\Request;
use App\Models\Skillcategory;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Log;
use Illuminate\Support\Facades\Storage;
use Lang;
use Session;
use LogicHelper;
use File;
use View;
use App\Models\Discipline;
use App\Models\Language;
use App\Models\Grade;
use App\Models\Examquestion;

//use Exception;

class QuestionsController extends Controller
{

    private $logicHelper;

    public function __construct(LogicHelper $logicHelper)
    {
        $this->logicHelper = $logicHelper;
    }

    /**
     * Display a listing of the questions.
     *
     * return resources/views/questions/index
     */
    public function index ()
    {
        $questions = Question::with ('answeroptions')->paginate (4);

        return view ('questions.index', compact ('questions'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create ()
    {
        $skills = Skill::pluck ('skill_name', 'id')->all ();
        $skillcategories = Skillcategory::pluck ('skill_category_name', 'id')->all ();
        $exercises = Exerciseset::pluck ('title', 'id')->all ();

        return view ('questions.create', compact ('skills', 'skillcategories', 'exercises'));
    }

    /**
     * Store a new question in the storage.
     */
    public function store (Request $request)
    {

        try {
            $data = $this->getData ($request);
            Question::create ($data);
            return redirect ()->route ('questions.question.index')
                ->with ('success_message', Lang::get('controller.question_add_message'));

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => Lang::get('controller.unexpected_error')]);
        }
    }

    public function store_question (Request $request)
    {
        try {
            // Storage::disk ('local')->append ('store_question.txt', $request);
            $data = $this->getData ($request);

            $id = Question::create ($data)->id;
            $question = Question::findOrFail ($id);
            if ($request->tags) {


            }
            if ($request->param) {

                $ext = $request->param->getClientOriginalExtension ();
                $path = Storage::disk ('params')->putFileAs ('', $request->file ('param'), 'param-' . $id . '.' . $ext);
                Question::where ('id', $id)->update (array('param' => $path));

            }
            return redirect ()->route ('questions.question.single_question', compact ('id'));

        } catch (Exception $exception) {

            return (Lang::get('controller.unexpected_error'));
        }
    }

    public function single_question ($id)
    {

        $question = Question::with ('skill', 'skillcategory', 'exercise')->findOrFail ($id);

        return view ('questions.single_question', compact ('question'));
    }

    /**
     * Display the specified question.
     *
     * param int $id
     *
     * return resources/views/questions/show
     */
    public function show ($id)
    {
        $question = Question::with ('skill', 'skillcategory', 'exercise')->findOrFail ($id);

        return view ('questions.show', compact ('question'));
    }

    /**
     * Show the form for editing the specified question.
     *
     * param int $id
     *
     * return resources/views/questions/edit
     */
    public function edit ($id)
    {
        $question = Question::findOrFail ($id);
        
        $skills = Skill::pluck ('skill_name', 'id')->all ();
        $skillcategories = Skillcategory::pluck ('skill_category_name', 'id')->all ();
        $exercises = Exerciseset::pluck ('title', 'id')->all ();

        return view ('questions.edit', compact ('question', 'skills', 'skillcategories', 'exercises'));
    }

    /**
     * Update the specified question in the storage.
     *
     * param  int $id
     * param Request $request
     *
     * return Illuminate/Http/RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update ($id, Request $request)
    {
        //dd($request);
        try {
            $data = $this->getData ($request);
            $request->param->store ('param');
            $question = Question::findOrFail ($id);
            $question->update ($data);
            return redirect ()->route ('questions.question.index')
            ->with ('success_message', Lang::get('controller.question_update_message'));
            
        } catch (Exception $exception) {
            
            return back ()->withInput ()
            ->withErrors (['unexpected_error' =>  Lang::get('controller.unexpected_error')]);
        }
    }
    
    /**
     * Update question
     * param Request $request
     * param int id
     * return View
     */
    public function update_question ($id, Request $request)
    {
        $queArr = Question::whereId($id)->first();


        // $this->logicHelper->dbStart();
        try {
            /*
            * MULTIPLE QUESTIONS ADD
            */
            $questionArray = json_decode($request->json_details_hidden,TRUE);
            //Question database json decode.
            $questionJson = json_decode($queArr->json_details,TRUE);
            // dd($request->parameter);
            //This Parameters.
            // if($request->parameter && $request->parameter != null){
                // $questionArray['Parameters'][0]['value']['filename'] = $filename;
                // $questionArray['Parameters'][0]['value']['filepath'] = $request->parameter;
            // }

            // if($request->parameter && $request->hasFile('parameter'))
            // {
            //     foreach($questionArray['Parameters'] as $paraKey => $parameter){

            //         $file = $request->parameter;
            
            //         $name = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            //         $ext = pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);
            //         $slug = time().'_'.Str::slug($name, '-');
            //         $storePath = public_path()."/assets/param/";

            //         if(!File::isDirectory($storePath)) {
            //             File::makeDirectory($storePath, 0777, true, true);
            //         }
            //         $file->move($storePath,$slug.".".$ext);
            //         $pathd = str_replace(public_path(),'',$storePath.$slug.".".$ext);
                    
            //         $filepath = asset($pathd);
            //         $filename = $slug.".".$ext;
            //         $questionArray['Parameters'][0]['value']['filename'] = $filename;
            //         $questionArray['Parameters'][0]['value']['filepath'] = $filepath;

            //     }

            if(isset($request->parameter_brows) && $request->hasFile('parameter_brows')) {
                $folderSize = app('App\Http\Controllers\AssetsController')->calculateDirectorySize();
    
                if($folderSize > 500){
                    Session::flash('unexpected_error', Lang::get('controller.quota_limit_error'));
                    Session::put('tab', 'detail');
                    return redirect()->back();
                } else {
    
                    $file = $request->parameter_brows;
        
                    $path = public_path().'/assets/eduplaycloud/upload/exercisesset/user-'.Auth::user()->id.'/csv';
                    $fileName = str_replace(' ', '_',$file->getClientOriginalName());
                    $filepath =  asset('/assets/eduplaycloud/upload/exercisesset/user-'.Auth::user()->id.'/csv'.'/'.$fileName);
        
                    // echo $fileName;
                    if (file_exists($path.'/'.$fileName)){
                        File::delete($path.'/'.$fileName);
                        $file->move($path, $fileName);
                    } else {
                        $file->move($path, $fileName);
                    }
                    $questionArray['Parameters'][0]['value']['filename'] = $fileName;
                    $questionArray['Parameters'][0]['value']['filepath'] = $filepath;
                }
             } else {
                $questionArray['Parameters'][0]['value']['filename'] = $questionArray['Parameters'][0]['value']['filename'];
             } 
                $filename = $questionArray['Parameters'][0]['value']['filename'];
                // Parameter file name store.
                Question::where('id','=', $id)
                    ->update(['param' => $filename]);
                
                if($request->parameter == null){
                    Question::where('id','=', $id)
                    ->update(['param' => null]);
                }
            // } 
            //else if($request->parameter_file_path == null){

            //     if($request->parameter_file_remove != ''){
            //         $file_path = public_path()."/assets/param/" . $request->parameter_file_remove;
                    
            //         //Unlink CSV file.
            //         if( File::exists($file_path)){
            //             unlink($file_path);
            //         }

            //         $questionArray['Parameters'][0]['value']['filename'] = null;
            //         $questionArray['Parameters'][0]['value']['filepath'] = null;
            //     }

            //     // Parameter file name store.
            //     Question::where('id','=', $id)
            //         ->update(['param' => null]);
            // }

            $questionDetails = "";
            //This each use for mulitple question add.
            foreach($questionArray['Questions'] as $qkey => $questions) {

                //Question Id Append with attribute.
                $questionArray['Questions'][$qkey]['question_id'] = $id;
                $questionArray['Questions'][$qkey]['Attributes']['Difficulty'] =  $request->difficultylevel;
                $questionArray['Questions'][$qkey]['Attributes']['MinTime'] =  $request->min_time;
                $questionArray['Questions'][$qkey]['Attributes']['MaxTime'] =  $request->max_time;
                $questionArray['Questions'][$qkey]['Attributes']['Tag'] =  $request->tags;
                //Questions.
                foreach($questions['Question_Description']['Sections'] as $qskey => $questionSection){
                   
                    // if($questionSection['SectionType'] == 'Plugin'){
                    //     if($questionSection['Plugin'] == 'image'){
                    //         //This is for image file path change.
                    //         foreach($request->question as $section){
                    //             if($section['section_type'] == 'image'){
                    //                 if (isset($section['image'])) {
                    //                     $image = $section['image'];
                    //                     $imagePath  = $this->uploadFile($image,Auth::user()->id,$request->hidden_exercise_id,$id);
                    //                     $questionArray['Questions'][$qkey]['Question_Description']['Sections'][$qskey]['Value'] = $imagePath;
                    //                 } 
                                    
                                    
                    //             }                            
                    //         }
                    //         //This is for auido file path change.
                    //     } else if ($questionSection['Plugin'] == 'audio'){
                    //         foreach($request->question as $section){
                    //             if ($section['section_type'] == 'audio'){
                    //                 if(isset($section['audio'])) {
                    //                     $audio = $section['audio'];
                    //                     $audioPath  = $this->uploadFile($audio,Auth::user()->id,$request->hidden_exercise_id,$id);
                    //                     $questionArray['Questions'][$qkey]['Question_Description']['Sections'][$qskey]['Value'] = $audioPath;
                    //                 } 
                    //             }
                    //         }
                    //     }
                    // }

                    //Store orignal test when paramater added.
                    if(isset($questionSection['SectionType']) && $questionSection['SectionType'] == 'text'){
                        // $questionArray['Questions'][$qkey]['Question_Description']['Sections'][$qskey]['Value'] = $questionArray['Questions'][$qkey]['Question_Description']['Sections'][$qskey]['Attributes']['sectionvalue'];
                        $questionArray['Questions'][$qkey]['Question_Description']['Sections'][$qskey]['Value'] = $request->question[($qskey+1)]['description'];
                        $questionDetails .= $questionArray['Questions'][$qkey]['Question_Description']['Sections'][$qskey]['Value'];
                    }

                    if(isset($questionSection['SectionType']) &&  $questionSection['SectionType'] == 'text'){
                        //Update Question in details for filter by question work.
                        Question::where('id','=', $id)->update([
                            'details' => $questionDetails,
                        ]);
                    }
                }
            
                $allAnswerId = [];
                //Answer
                foreach($questions['Answers']['Choices'] as $chkey =>$choices){
                    //Answer Section each.
                    foreach($choices['Sections'] as $chSkey => $ansSection){      
                        
                        
                    
                        if($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['SectionType'] == 'Plugin'){
                            // if($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Plugin'] == 'image' ){
                            //     //This is for image file path change and upload image for answer. 
                                
                            //     if (isset($request->answer['op_' . ($chkey + 1)][($chSkey + 1)]['image'])) {
                            //         $image = $request->answer['op_' . ($chkey + 1)][($chSkey + 1)]['image'];
                            //         $imagePath  = $this->uploadFile($image,Auth::user()->id,$request->hidden_exercise_id,$id);
                            //         $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Value'] = $imagePath;
                            //         $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Attributes']['sectiontype'] = 'image';
                            //         $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Attributes']['sectionvalue'] = $imagePath;
    
                            //     } 
                                
                               
                            // } else if($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Plugin'] == 'audio' ){
                                
                            //     if (isset($request->answer['op_' . ($chkey + 1)][($chSkey + 1)]['audio'])) {
                            //         //This is for audio file path change and upload audio for answer.                             
                            //         $audio = $request->answer['op_' . ($chkey + 1)][($chSkey + 1)]['audio'];
                            //         $audioPath  = $this->uploadFile($audio,Auth::user()->id,$request->hidden_exercise_id,$id);
                            //         $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Value'] = $audioPath;
                            //         $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Attributes']['sectiontype'] = 'audio';
                            //         $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Attributes']['sectionvalue'] = $audioPath;
                            //     } 
                                
                                
                            // }
                          
                            
                        }
                        //Store orignal test when paramater added.
                        if($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['SectionType'] == 'text'){
                            if (isset($request->answer['op_' . ($chkey + 1)][($chSkey + 1)])){
                                $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Value'] =  $request->answer['op_'.($chkey+1)][($chSkey+1)]['description'];
                            }
                            // $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Value'] = $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Attributes']['sectionvalue'];
                        }
                         // Store orinal text from input.
                        //if($ansSection['SectionType'] == 'text'){
                            // $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Value'] = $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Attributes']['sectionvalue'];
                        //}

                        //Make array for using answer store.
                        $anstype = $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['SectionType'];
                        $details = $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Value'];
                        $answerJson = json_encode($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections']);
                        $correct = $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Attributes']['IsCorrect'] == 1 ? 1 : 0;
                        
                        
                        
                    }
                    
                        // //Make array for using answer store.
                        $anstype = head($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections']);
                        $details = head($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections']);
                        $correct = $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Attributes']['IsCorrect'] == 1 ? 1 : 0;
                        if (isset($questionJson['Questions'][$qkey]['Answers']['Choices'][$chkey]['Attributes']['id'])) {
                            $ansId = $questionJson['Questions'][$qkey]['Answers']['Choices'][$chkey]['Attributes']['id'];
                        } else {
                            $ansId = 0;
                        }
                        
                        $answerJson = json_encode(head($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections']));

                        // //Call answer store method.
                        // $allAnswerId[] = $answere_id = $this->answerUpdateWithNewStore($id,$ansId,$anstype,$details,$answerJson,$correct,($chkey + 1));
                        $answere_id = $this->answerUpdateWithNewStore($id,$ansId,$anstype,$details,$answerJson,$correct,($chkey + 1));
                        $allAnswerId[] = $answere_id;
                        //Append answer id in question json for using practies.
                        $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Attributes']['id'] = $answere_id;

                }

              

                //Delete Other Answer
                Answeroption::whereNotIn('id',$allAnswerId)->where('question_id','=',$id)->delete();  

                //Hints
                foreach($questions['Hints']['HintList'] as $hintkey => $hintList){
                    //Hints Section
                    foreach($hintList['Sections'] as $hskey => $hintSection){
                        // if($questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['SectionType'] == 'Plugin'){
                        //     if($questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Plugin'] == 'image'){
                                
                        //         if (isset($request->hint[($hintkey + 1)][($hskey + 1)]['image'])) {
                        //             //This is for image file path change and upload image for answer.                            
                        //             $image = $request->hint[($hintkey + 1)][($hskey + 1)]['image'];
                        //             $imagePath  = $this->uploadFile($image,Auth::user()->id,$request->hidden_exercise_id,$id);
                        //             $questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Value'] = $imagePath;
                        //             $questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Attributes']['sectionvalue'] = 'image';
                        //             $questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Attributes']['sectionvalue'] = $imagePath;
                        //         } 
                                
                                

                        //     } else if($questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Plugin'] == 'audio' ){
                                
                        //         if (isset($request->hint[($hintkey + 1)][($hskey + 1)]['audio'])) {
                        //             //This is for audio file path change and upload audio for answer.                             
                        //             $audio = $request->hint[($hintkey + 1)][($hskey + 1)]['audio'];
                        //             $audioPath  = $this->uploadFile($audio,Auth::user()->id,$request->hidden_exercise_id,$id);
                        //             $questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Value'] = $audioPath;
                        //             $questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Attributes']['sectionvalue'] = 'audio';
                        //             $questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Attributes']['sectionvalue'] = $audioPath;
                        //         } 
                                
                                
                        //     }

                            
                        // }
                        // hint in storage original input text.
                       if($questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['SectionType'] == 'text'){
                        //    $questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Value'] = $questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Attributes']['sectionvalue'];
                            if (isset($request->hint[($hintkey + 1)][($hskey + 1)])) {
                                $questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Value'] = $request->hint[($hintkey+1)][($hskey+1)]['description'];
                            }
                       }
                    }
                }
            }
            //Make Question Array to final json.
            $question_json = json_encode($questionArray, TRUE);
            
            Question::where('id','=', $id)->update(['json_details' => $question_json]);

            Question::where('id','=', $id)->update([
                // 'json_details' => $question_json,
                'maxtime' => $request->max_time,
                'mintime' => $request->min_time,
                'tag' => $request->tags,
                'difficultylevel' => $request->difficultylevel
            ]);

            Session::put('tab', 'detail');
            return redirect()->route('exercisesets.exerciseset.show',[$queArr->exercise_id,'1'])->with(['success_message' => Lang::get('controller.question_update_message')]);            
            // ------------------------------------------------------------------------

        } catch (Exception $exception) {

            // $this->logicHelper->dbRollBack();
            Session::put('tab', 'detail');
            return redirect()->route('exercisesets.exerciseset.show',[$queArr->exercise_id,'1'])->with(['unexpected_error' => Lang::get('controller.unexpected_error')]);

        }
    }

    /**
     * Answer store with question create;
     * Developed by Wc
     */
    public function answerUpdateWithNewStore($question_id,$ansId,$anstype,$details,$answerJson,$correct,$order){
        $answare_options = [];
        $answare_options['details'] = $details['Value'];
        $answare_options['json_details'] = $answerJson;
        $answare_options['answer_type'] = $anstype['SectionType'];
        $answare_options['iscorrect'] = $correct;
        $answare_options['sort_order'] = $order;     
        $answere = Answeroption::where('id',$ansId)->first();
        if(!empty($answere)){
            Answeroption::where('id',$ansId)->update($answare_options);
            return $ansId;
        } else {    
            $answare_options['question_id'] = $question_id;
            $newAns = Answeroption::create($answare_options);
            return $newAns->id;
        }
    }

    /**
     * 
     * Develop by WC
     * 
     * Upload files function for question create.
     */
    public function uploadFile($file,$uid,$id,$questionId){
     
        $name = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
        $ext = pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);
        $slug = Str::slug($name, '-');
        $storePath = public_path()."/assets/eduplaycloud/question/user-$uid/ex-$id/que-$questionId";
        //dd($storePath);
        if(!File::isDirectory($storePath))
        {
            File::makeDirectory($storePath, 0777, true, true);
        }
        $file->move($storePath."/",$slug.".".$ext);
        $pathd = str_replace(public_path(),'',$storePath."/".$slug.".".$ext);
        $path = 'src:'.asset($pathd);
        return $path;
    }


    public function edit_question ($id)
    {

        //session(['key' => $id]);
        try {
            // Auth::user ()->can('update');

            $question = Question::findOrFail ($id);
            $exerciseset = Exerciseset::with('language')->findorFail($question->exercise_id);

            // Develop By WC -----
            $sectionType = ['text' => 'Text', 'image' => 'Image', 'video' => 'Video', 'audio' => 'Audio','plugin' => 'Plugins'];
            //return view ('questions.edit', compact ('question', 'sectionType','exerciseset'))->render();

            $path= public_path('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/image');
            $audioPath= public_path('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/audio');
            $csvPath= public_path('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/csv');
            
            $images = File::files($path);
            $audio = File::files($audioPath);
            $csvs = File::files($csvPath);

            return view ('questions.edit', compact ('question', 'sectionType','exerciseset','images', 'audio','csvs'));
            // -------------------
            $exersise_id = $question->exercise_id;
            $skillcategory_id = $question->skillcategory_id;
            $discipline_id = Exerciseset::where ('id', $exersise_id)->first ();
            $discipline_id = $discipline_id->discipline_id;

            $skillcategories = Skillcategory::where ('discipline_id', '=', $discipline_id)->pluck ('skill_category_name', 'id')->all ();


            $sk_id = Skillcategory::select ('id')->where ('discipline_id', '=', $discipline_id)->get ()->toArray ();

            if ($skillcategory_id == 0) {
                $skills = null;
            } else {
                $skills = Skill::where ('skill_category_id', $skillcategory_id)->pluck ('skill_name', 'id')->all ();
            }


            //   $skills = Skill::pluck ('skill_name', 'id')->all ();
            $passages = Passage::where ('exercise_id', '=', $_POST['sid'])->get ();
            $passages = $passages->pluck ('passage_title', 'id');
            $exercises = Exerciseset::pluck ('title', 'id')->all ();
            return view ('questions.form-exercise', compact ('question', 'skills', 'skillcategories', 'exercises', 'passages'));

        } catch (Exception $e) {
            Storage::disk ('local')->append ('errorajax.txt', $e);
            report ($e);
            return false;
        }
    }

    public function add_question (Request $request)
    {
        try {
            if ($request->has ('sid')) {
                $exersise_id = $request->sid;
            } else {
                $exersise_id = 0;
            }

            $question = null;

            $discipline_id = Exerciseset::where ('id', $exersise_id)->first ();
            $discipline_id = $discipline_id->discipline_id;

            $skillcategories = Skillcategory::where ('discipline_id', '=', $discipline_id)->pluck ('skill_category_name', 'id')->all ();

            $sk_id = Skillcategory::select ('id')->where ('discipline_id', '=', $discipline_id)->get ()->toArray ();

            $skills = Skill::whereIn ('skill_category_id', $sk_id)->pluck ('skill_name', 'id')->all ();
            $exercises = Exerciseset::pluck ('title', 'id')->all ();
            $skills = null;
            $passages = Passage::where ('exercise_id', '=', $exersise_id)->get ();
            $passages = $passages->pluck ('passage_title', 'id');

            return view ('questions.form-exercise', compact ('question', 'skills', 'skillcategories', 'exercises', 'passages'));

        } catch (Exception $e) {
            Storage::disk ('local')->append ('errorajax.txt', $e);
            report ($e);
            return false;
        }
    }

    /**
     * Remove the specified question from the storage.
     *
     * param  int $id
     *
     * return Illuminate/Http/RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {
        // return $id;
        try {
            $question = Question::findOrFail ($id);

            //Check exam has this question assinge or not.
            $examQuestion = Examquestion::where('question_id','=',$id)->first();
            if($examQuestion != null){
                Session::flash('unexpected_error', Lang::get('controller.question_nor_delete_message'));
                Session::put('tab', 'detail');
                return redirect()->back(); 
            } else {
               
                // Develop By WC
                $path = public_path('assets/eduplaycloud/question/user-'.Auth::user()->id.'/ex-'.$question->exercise_id.'/que-'.$id.'/');
                if(is_dir($path)){
                    $files = glob( $path . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
            
                    foreach( $files as $file ){
                        unlink( $file );      
                    }
            
                    rmdir( $path );
                } elseif(is_file($path)) {
                    unlink( $path );  
                }
                // -----------------------------
                $question->delete ();
                $msg = 'que_ans' . $id;
                // Develop By WC
                Session::flash('success_message', Lang::get('controller.question_delete_message'));
                Session::put('tab', 'detail');
                return redirect()->back(); 
                // ---------------------------------
                // return ($msg);

            }



        } catch (Exception $exception) {

              return back()->withInput()
                         ->withErrors(['unexpected_error' =>  Lang::get('controller.unexpected_error')]);
        }
    }


    public function api_question ($id)
    {

        $question = Question::findorfail ($id);
        return view ('questions.single_question_for_api', compact ('question'));

    }


    public function api_answer ($id)
    {

        $answer = Answeroption::findorfail ($id);

        return view ('questions.single_answer_for_api', compact ('answer'));

    }

    public function savequestionasimage ()
    {
        //just a random name for the image file
        $random = rand (10, 10000000);

        //convert the binary to image using file_put_contents
        $savefile = @file_put_contents ("assets/images/output/$random.png", base64_decode (explode (",", $_POST['data'])[1]));
        //if the file saved properly, print the file name
        if ($savefile) {
            echo $random;
        }
    }


    public function getskills ($skill_categories_id)
    {

        $skills = Skill::where ('skill_category_id', '=', $skill_categories_id)->select ('skill_name', 'id')->get ();

        return Response ($skills);

    }

    /**
     * Get the request's data from the request.
     *
     * param Illuminate/Http/Request/Request $request
     * return array
     */
    protected function getData (Request $request)
    {
        $rules = [
            'details' => 'required',
            'param' => 'nullable',
            'questiontype' => 'required',
            'skill_id' => 'nullable',
            'skillcategory_id' => 'nullable',
            'passage_id' => 'nullable',
            'maxtime' => 'required|numeric|min:0|max:300',
            'mintime' => 'required|numeric|min:0|max:300',
            'size' => 'nullable',
            'exercise_id' => 'nullable',
            'difficultylevel' => 'required',
            'hint' => 'nullable',

        ];

        $data = $request->validate ($rules);

        return $data;
    }

    /**
     * Develop by Wc 
     * 
     * This is for selecet curriculum for the question's link to skill.
     * 
     * param Illuminate/Http/Request $request
     * return resources/views/questions/select-curriculum
     */
    function postQuestionsLinkToSkill(Request $request){

        if(!empty($request->exerciseId)){
            $exercises_id = $request->exerciseId;
        } else {
            $exercises_id = Session::get('link_to_skill_session_data.link_exercisets_id');
        }
        $exerciseset = Exerciseset::with(['topics','discipline'])->findOrFail($exercises_id);
        
        if (!empty($request->questionsIds)) {
            $question_ids = $request->questionsIds;
        } else {
            $question_ids = Session::get('link_to_skill_session_data.link_question_ids');
        }

        //Save in sessions 
        Session::put('link_to_skill_session_data',[
            'link_exercisets_id'=>$exercises_id,
            'link_question_ids' => $question_ids
        ]);

        if($exerciseset->discipline_id === NULL){

            $disciplines=Discipline::where('language_preference_id','=',$exerciseset->language_id)
            ->where('topic_id','=',$exerciseset->topic_id)
            ->where('approve_status','approved')
            ->where('publish_status','published')
            ->with('topics')
            ->orderBy('discipline_name', 'asc')
            ->get();
            $languages = Language::get();

            return view('questions.select-curriculum', compact('question_ids','disciplines','exerciseset','languages'));
        } else {
            
            // $skill_category = Skillcategory::where('discipline_id', $exerciseset->discipline_id)
            // ->where('approve_status','=','approved')
            // ->where('publish_status','=','published')
            // ->with(['skill' => function ($skill) use ($exerciseset){
            //     $skill->where('grade_id','=',$exerciseset->grade_id)
            //     ->where('approve_status','=','approved')
            //     ->where('publish_status','=','published');
            // }])->get();



            // $disciplines = Discipline::where( [['id', '=', $exerciseset->discipline_id], ['publish_status', 'like', 'published']])
            // ->with('curriculum_gradelist.grades.skillCategory.skill')->first()->toArray();

            $skill_category = Skillcategory::where('discipline_id','=', $exerciseset->discipline_id)
                              ->where('approve_status','=','approved')->where('publish_status','=','published')
                              ->with(['skill' => function($skill) use($exerciseset){
                                $skill->where('approve_status','=','approved')->where('publish_status','=','published')
                                      ->get();
                              }])->get();

            // echo "<pre>";
            // print_r($skill_category->toArray());
            // echo "</pre>";
            // exit;
            return view('questions.skills',compact('question_ids','exerciseset','skill_category'));
       
        }

        

    }
    
    /**
     * update Exerciseset in Grade or curriculum for link to skill.
     *
     * Develop By WC.
     * return void
     */
    public function insertCurriculumToExerciseset(Request $request){
        try {
            
            if (!empty(request('exercise_id'))) {
                $curriculum_exercise_id = request('exercise_id');
            } else {
                $curriculum_exercise_id = Session::get('curriculum_to_exe_session_data.curriculum_exercise_id');
            }
            $exerciseset = Exerciseset::findOrFail($curriculum_exercise_id);

            if (!empty(request('discipline_id'))) {
                $curriculum_discipline_id = request('discipline_id');
            } else {
                $curriculum_discipline_id = Session::get('curriculum_to_exe_session_data.curriculum_discipline_id');
            }

            if (!empty(request('grade_id'))) {
                $curriculum_grade_id = request('grade_id');
            } else {
                $curriculum_grade_id = Session::get('curriculum_to_exe_session_data.curriculum_grade_id');
            }

            $data = ['discipline_id' => $curriculum_discipline_id,'grade_id' => $curriculum_grade_id ];
            $exerciseset->fill($data);
            $exerciseset->save();

            // $skill_category = Skillcategory::where('discipline_id', $exerciseset->discipline_id)
            // ->where('approve_status','=','approved')
            // ->where('publish_status','=','published')
            // ->with(['skill' => function ($skill) use ($exerciseset){
            //     $skill->where('grade_id','=',$exerciseset->grade_id)
            //     ->where('approve_status','=','approved')
            //     ->where('publish_status','=','published');
            // }])->get();
            $skill_category = Skillcategory::where('discipline_id','=', $exerciseset->discipline_id)
            ->where('approve_status','=','approved')->where('publish_status','=','published')
            ->with(['skill' => function($skill) use($exerciseset){
              $skill->where('grade_id','=', $exerciseset->grade_id)
                    ->where('approve_status','=','approved')->where('publish_status','=','published')
                    ->groupby('skill_category_id')->get();
            }])->get();

            if (!empty(request('question_ids'))) {
                $curriculum_question_ids = request('question_ids');
            } else {
                $curriculum_question_ids = Session::get('curriculum_to_exe_session_data.curriculum_question_ids');
            }

            $question_ids = $curriculum_question_ids;
            
            //Save in sessions 
            Session::put('curriculum_to_exe_session_data',[
                'curriculum_exercise_id'=>$curriculum_exercise_id,
                'curriculum_discipline_id'=>$curriculum_discipline_id,
                'curriculum_grade_id' => $curriculum_grade_id,
                'curriculum_question_ids' => $curriculum_question_ids
            ]);

            
            return view('questions.skills',compact('question_ids','exerciseset','skill_category'));

        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => Lang::get('controller.unexpected_error')]);
        }
    }

    /**
     * linked all question with on skill and skill categories.
     * param Request $request
     * return Redirect
     */
    public function questionsLinked(Request $request) 
    {
        $questions = explode(',',$request->questions);    
        $exercises_id = $request->exerciseset_id;
        $skill_category_id = $request->skill_category_id;
        $skill_id = $request->skill_id;
        foreach ($questions as $question_id) {
            Question::where('id',$question_id)->update(['skillcategory_id' => $skill_category_id, 'skill_id' => $skill_id ]);
        }
        return redirect()->route('exercisesets.exerciseset.show',[$exercises_id,$request->exerciseset_public])->with(['success_message' => Lang::get('messages.que_linked_skill')]);
    }

    /**
     * This function use for link to skill in curriculum filter data.
     * param Request $request
     * return Redirect
     */
    public function LinkToSkillSelectCurriculumFilter()
    {
        $id = request('exercise_id');
        $exerciseset = Exerciseset::findOrFail($id);
        $disciplines = app('App\Http\Controllers\Exercises\ExercisesetsController')->curriculumFilterData();
        return view('eduplaycloud.users.private-library.filter-curriculum',compact('disciplines','exerciseset'))->render();
    }


     /**
     * Develop by WC
     * 
     * Get question page render
     */
    public function getQuestionsFilter($exerciseId){
        $questions = $this->questionsFilteredData($exerciseId);

        foreach($questions as $question){
            $josnArr = json_decode($question->json_details);

            if($question->skill_id !== Null && $question->skillcategory_id !== Null){
                $josnArr->Questions[0]->Attributes->SkillName = $question->skill->skill_name;
            } else {
                $josnArr->Questions[0]->Attributes->SkillName = 'N/A';
            }

            $josn =   json_encode($josnArr);

            $question->json_details = $josn;
        }
        // dd($questions);
        $exerciseset = Exerciseset::with('discipline','grade','language')->findOrFail($exerciseId);

        return view('questions.exercise_question',compact('questions','exerciseset'))->render();

    }

    public function questionsFilteredData($exerciseId){
        
        $questionsData = Question::with('skill','skillcategory','exercise','answeroptions')
        ->where('exercise_id','=',$exerciseId)->where('json_details', '!=', NULL);
        
         //Fetch data by questionsData's questions.
         if(!empty(request('Details_search'))){
            if(request('Details_operator') === 'like'){
                $questionsData->where('details','LIKE','%'.request('Details_search').'%');
            } else {
                $questionsData->where('details','=',request('Details_search'));                            
            }
        }

        //Fetch data by questionsData's questions.
        if(!empty(request('Tag_search'))){
            if(request('Tag_operator') === 'like'){
                $questionsData->where('tag','LIKE','%'.request('Tag_search').'%');
            } else {
                $questionsData->where('tag','=',request('Tag_search'));                            
            }
        }

        //Sorting Data by order.
        if(!empty(request('Sort_search')) && request('Sort_search') === 'Descending' ){
            
            $questionsData->orderBy('id', 'desc');
        } else {
            $questionsData->orderBy('id', 'asc');
        }

        //Fetch data by skill category and skill.
        if(request('skill_category') != ""){
            if(request('skill') != 0){
              $questionsData->where('skill_id','=',request('skill'))->where('skillcategory_id','=',request('skill_category'));
            } else {
              $questionsData->where('skillcategory_id','=',request('skill_category'));
            }
        }

        //Fetch data by min-time.
        
        if(request('Min-time_search') != ""){
            $questionsData->where('mintime',request('Min-time_operator'),request('Min-time_search'));
        }
        
        //Fetch data by Max-time.
        if(request('Max-time_search') != ""){
            $questionsData->where('maxtime',request('Max-time_operator'),request('Max-time_search'));
        }

        //Fetch data by Difficuly.
        if(!empty(request('Difficuly_search'))){
            $questionsData->where('difficultylevel','=',request('Difficuly_search'));
        }
        
        return $questionsData->paginate(25);
    }

}
