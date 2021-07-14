<?php

namespace App\Http\Controllers\Disciplines;

use App\Http\Controllers\Controller;
use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Disciplineversion;
use App\Models\Skillcategory;
use App\Models\Skill;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;

use Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;

use Exception;

class CollaborationController extends Controller
{
    public function __construct ()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        $this->middleware ('auth');

    }

    /**
     * list the latest version of the curriculum's skills and skill categories by grade and
     * 
     * param int $disciplineid
     * return Illuminate\View\View
     */
    public function index ($disciplineid)
    {
        $message_text='';
        $discipline = Discipline::findorfail ($disciplineid);

        if (Auth::user ()->can ('collaborate', $discipline)) {
            $discipline_name = $discipline->discipline_name;
            $lastversion = Disciplineversion::where ('discipline_id', '=', $disciplineid)->max ('version');
            if (is_null ($lastversion) == true) $lastversion = 0;

            $skillcategories = Skillcategory::Where ([['discipline_id', '=', $disciplineid], ['version', '=', $lastversion], ['publish_status', '=', 'published']])
                ->orWhere ([['discipline_id', '=', $disciplineid], ['version', '>', $lastversion], ['origin_id', '=', 0]])
                ->get ()->sortBy ('sort_order');
            $topics = Topic::all ('id', 'id')->all (); // why are we getting all topics (disciplines)
            $grades = Grade::all ('grade_name', 'id')->all ();
            $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();
            // check what's returned to the view (discipline!!! not disciplines!!
            return view ('collaboration.collaboration', compact ('skillcategories','disciplines' , 'topics', 'grades', 'lastversion', 'discipline' ,'message_text'));
        }
        return view ('unauthorized');
    }

    /**
     * sorting skills
     * 
     * param Illuminate\Http\Request $request
     * return Redirect
     */
    public function sortskill (Request $request)
    {

        try {
            $json = $request->input ('jsonString');
            $array = json_decode ($json, true);
            Storage::disk ('local')->append ('fileroche.txt', $json);
        
            Storage::disk ('local')->append ('fileroche.txt', '------------');
        } // Validate the value...
        catch (Exception $e) {
            Storage::disk ('local')->append ('errorlogs.txt', $e);
            report ($e);

            return false;
        }

    }

    /**
     * edit your own updates of the skill
     * 
     * param int $id
     * return Redirect
     */
    public function edit_modal ($id)
    {
        try {

            $child_skill = skill::Where ([['origin_id', '=', $id], ['updatedby', '=', Auth::user ()->id]])->first ();
            if ($child_skill) {
                $skill = $child_skill;
            } else {
                $skill = Skill::findOrFail ($id);

            }

            $skillcategories = Skillcategory::all ('skill_category_name', 'id')->all ();
            $topics = Topic::all ('id', 'id')->all ();
            $grades = Grade::all ('grade_name', 'id')->all ();
            return view ('collaboration.form_skill_collaboration', compact ('skill', 'skillcategories', 'topics', 'grades'));

        } catch (Exception $e) {
            Storage::disk ('local')->append ('errorajax.txt', $e);
            report ($e);
            return false;
        }
    }

    /**
     * edit your own updates of  the skill category
     * 
     * param int $id
     * return Illuminate\View\View
     */
    public function edit_skillcategory_modal ($id)
    {
        try {
            $child_skillcategory = Skillcategory::Where ([['origin_id', '=', $id], ['updatedby', '=', Auth::user ()->id]])->first ();
            if ($child_skillcategory) {
                $skillcategory = $child_skillcategory;
            } else {
                $skillcategory = Skillcategory::findOrFail ($id);

            }

            $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();

            return view ('collaboration.form_skillcatcollaboration', compact ('skillcategory', 'disciplines'));

        } catch (Exception $e) {
            Storage::disk ('local')->append ('errorajax.txt', $e);
            report ($e);
            return false;
        }
    }

    /**
     * Open Skill Modal
     * 
     * return Illuminate\View\View
     * param Illuminate\Http\Request $request
     */
    public function skillmodal ()
    {

        $skillcategories = Skillcategory::pluck ('skill_category_name', 'id')->all ();
        $topics = Topic::pluck ('id', 'id')->all ();
        $grades = Grade::pluck ('grade_name', 'id')->all ();

        return view ('collaborationkillmodal', compact ('skillcategories', 'topics', 'grades'));

    }

    /**
     * suggest deletion of skill
     * 
     * param int $id
     * return Redirect
     */
    public function destroyskill ($id)
    {
        try {

            $skill = Skill::findOrFail ($id);
            $skillcategory = Skillcategory::findOrFail ($skill->skill_category_id);
            $shild_skill = Skill::where ('origin_id', '=', $id)->first ();
            $currentversion =$this-> getlastpublishedversion ($skill->skill_category_id);

            if($currentversion==$skill->version) {
            if ($shild_skill) {
                if ($shild_skill->publish_status == 'deleted' && $shild_skill->approve_status == 'pending') {
                    $message_text1 = 'the skill ' . $skill->skill_name . ' already  deleted!!! ';
                } else {

                    $shild_skill->skill_name = $skill->skill_name;
                    $shild_skill->publish_status = 'deleted';
                    $shild_skill->approve_status = 'pending';
                    $shild_skill->origin_id = $id;
                    $shild_skill->updatedby = Auth::user ()->id;
                    $shild_skill->save ();
                    $message_text1 = 'the skill ' . $shild_skill->skill_name . 'was successfully deleted! ';
                }

            } else {
                if ($skill->publish_status = 'published') {
                    $newskill = $skill->replicate ();
                    $newskill->origin_id = $id;
                    $newskill->updatedby = Auth::user ()->id;
                    $newskill->publish_status = 'deleted';
                    $newskill->approve_status = 'pending';
                    $newskill->version = $skill->version + 1;
                    $newskill->save ();
                    $message_text1 = 'the skill ' . $newskill->skill_name . ' was successfully deleted! ';

                }
            }
            }
            else {
                    $skill->delete ();
                    $message_text1 = 'the skill ' . $skill->skill_name . ' was successfully deleted! ';
                }


            return redirect ()->route ('collaboration.index', $skillcategory->discipline_id)->with ('skill_category_id', $skill->skill_category_id)->with ('message_text', $message_text1);
           
        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Delete skill category
     * 
     * param int $id
     * return Redirect
     */
    public function destroyskillcategory ($id)
    {
        try {

            $skillcategory = Skillcategory::findOrFail ($id);
            $currentversion =$this-> getlastpublishedversion ($id);


          
            if ($currentversion == $skillcategory->version) {
                $skillcategory_child = Skillcategory::where ('origin_id', '=', $id)->where ('updatedby', '=', Auth::user ()->id)->first ();
          
                if ($skillcategory_child) {

                    if ($skillcategory_child->publish_status == 'deleted' && $skillcategory_child->approve_status == 'pending' && $skillcategory_child->updatedby == Auth::user ()->id) {
                        $message_text1 = 'the skill category: ' . $skillcategory->skill_category_name . ' already  deleted!!! ';
                    } else {

                        $skillcategory_child->skill_category_name = $skillcategory->skill_category_name;
                        $skillcategory_child->publish_status = 'deleted';
                        $skillcategory_child->approve_status = 'pending';
                        $skillcategory_child->updatedby = Auth::user ()->id;
                        $skillcategory_child->origin_id = $id;
                        $skillcategory_child->save ();
                        $message_text1 = 'the skill category ' . $skillcategory_child->skill_category_name . 'was successfully deleted! ';
                    }

                } else {


                    if ($skillcategory->publish_status = 'published') {
                        $newskillcategory = $skillcategory->replicate ();
                        $newskillcategory->origin_id = $id;
                        $newskillcategory->updatedby = Auth::user ()->id;
                        $newskillcategory->publish_status = 'deleted';
                        $newskillcategory->approve_status = 'pending';
                        $newskillcategory->version = $skillcategory->version + 1;
                        $newskillcategory->save ();
                        $message_text1 = 'the skill category ' . $newskillcategory->skill_category_name . ' was successfully deleted! ';
                    }
                }
            } else {
                $id=$skillcategory->origin_id;
                $skillcategory->delete ();
                $message_text1 = 'the skill category ' . $skillcategory->skill_category_name . ' was successfully deleted! ';
            }


            return redirect ()->route ('collaboration.index', $skillcategory->discipline_id)->with ('skill_category_id', $id)->with ('message_text', $message_text1);
            
        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Get Last published version
     * param int $skill_category_id
     * return Response
     */
    private function  getlastpublishedversion ($skill_category_id)
    {
        $skill_category=Skillcategory::where('id',$skill_category_id)->first ();

        $discipline_id=$skill_category->discipline_id;
        $currentpublishedversion = Disciplineversion::where ('discipline_id', '=', $discipline_id)->max ('version');

        return $currentpublishedversion;

    }

}
