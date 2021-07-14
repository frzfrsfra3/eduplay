<?php

namespace App\React\Disciplines;

use App\Http\Controllers\Controller;
use App\Models\Discipline;
use App\Models\Curriculum_gradelist;
use App\Models\Topic;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Disciplineversion;
use App\Models\Country;
use App\Models\Skillcategory;
use App\Models\Skill;
use App\Models\Grade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

//use Exception;

class DisciplinesController extends Controller
{

    /*** Display a listing of the disciplines.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        // fetch with any tag listed....


        if (isset($_GET['searchkey'])) {
            $name = $_GET['searchkey'];
        } else {
            $name = '';
        }
        $curricula = Curriculum_gradelist::pluck ('curriculum_gradelist_name', 'id')->all ();
      //  $country_list = Country::all ('country_name', 'id');
        $languages = Language::all ('id','language');
        $topics=Topic::all ( 'id','topic_name')->all();

        $disciplines = Discipline::where ([['discipline_name', 'like', '%' . $name . '%'], ['publish_status', 'like', 'published']])->orwhere ([['description', 'like', '%' . $name . '%'], ['publish_status', 'like', 'published']])->paginate (10);
        $disciplines['languages']=($languages);
        $disciplines['topics']=($topics);
        $disciplines['curriculum_gradelist']=($curricula);
        return response()->json($disciplines,201);
        //return view ('disciplines.index', compact ('disciplines'));


    }


    /*** Display the specified discipline.
     */
    public function show ($id)
    {

        $data['discipline_id'] = $id;

        $validator = $this->id_validation ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);
        }
        $discipline = Discipline::findOrFail ($id);

        $curricula = Curriculum_gradelist::pluck ('curriculum_gradelist_name', 'id')->all ();
        //  $country_list = Country::all ('country_name', 'id');
        $languages = Language::all ('id','language');
        $topics=Topic::all ( 'id','topic_name')->all();

        $discipline['languages']=($languages);
        $discipline['topics']=($topics);
        $discipline['curriculum_gradelist']=($curricula);
        return response()->json($discipline,201);
        //   return view ('disciplines.show', compact ('discipline'));
    }

    /**
     * Update the specified discipline in the storage.
     ** param  int $id
     * param Illuminate\Http\Request $request
     ** return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update ($id, Request $request)
    {
        $data['discipline_id'] = $id;

        $validator = $this->id_validation ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);
        }
        $data =$request->toArray();

        $validator = $this->disciplinevalidation ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse ($messages);


            return json_encode ($responce);
        }

        $discipline = Discipline::findOrFail ($id);
        $discipline->update ($data);
        // dd($discipline);
        //  $discipline->tag (explode (',', $request->tags));

        return response()->json($discipline,200);



    }

    /*** Store a new discipline in the storage.
     */
    public function store (Request $request)
    {

        $data = $request->toArray();

        $validator = $this->disciplinevalidation ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse ($messages);


            return json_encode ($responce);
        }




        $responce = Discipline::create($data);


        return $responce;

    }

    /*
     * filter the Disciplines
     * */
    public function filter_country_id (Request $request)
    {

        $country_id = $request->input ('country_id');
        $disciplinewithrelation = Discipline::with ('curriculum.country')->get ()->where ('curriculum.country_id', '=', $country_id);
        $curricula = Curriculum::all ('curriculum_gradelist_name', 'id')->all ();
        $country_list = Country::all ('country_name', 'id');
        $languages = Language::all ('language', 'id');
        $data_collection = collect ();


        foreach ($disciplinewithrelation as $discipline1) {
            $country_name = $discipline1->curriculum_gradelist->country->country_name;
            $curriculum_gradelist_name = $discipline1->curriculum_gradelist->curriculum_gradelist_name;
            $nbr_of_exercisesets = $discipline1->exercisesets ()->count ();
            $nbr_of_classes = $discipline1->courseclasses ()->count ();
            $data_collection->push (['id' => $discipline1->id, 'nbr_of_exercisesets' => $nbr_of_exercisesets, 'nbr_of_classes' => $nbr_of_classes,
                'country_name' => $country_name, 'curriculum_gradelist_name' => $curriculum_gradelist_name]);

        }
        return view ('disciplines.index', ['disciplines' => $disciplinewithrelation, 'data_collection' => $data_collection, 'curricula' => $curricula,
            'country_list' => $country_list, 'languages' => $languages]);
    }

    /*
     * collect all Skills and the Skills Category for a slected disicpilne by the last published  version
     *
     *
     * */
    public function getknowledgemap ($id, Request $request)
    {

        $discipline = Discipline::findorfail ($id);

        $grade_id = request ()->get ('grade_id');
        $lastversion = Disciplineversion::where ('discipline_id', '=', $id)->max ('version');
        if (is_null ($lastversion) == true) $lastversion = 0;
        $skillcategories = Skillcategory::Where ([['discipline_id', '=', $id], ['version', '=', $lastversion]], ['publish_status', '=', 'published'])->get ()->sortBy ('sort_order');
        if ($grade_id == null || $grade_id == 0) {
            $skills = skill::with ('skillcategory')->get ()->Where ('skillcategory.discipline_id', '=', $id)->sortBy ('skillcategory.id');
        } else {
            $skills = skill::with ('skillcategory')->Where ([['grade_id', '=', $grade_id], ['version', '=', $lastversion]], [['skillcategory.discipline_id', '=', $id]])->get ()
                ->sortBy ('sort_order');
        }
        $grades = Grade::all ('grade_name', 'id')->all ();
        return view ('disciplines.knowledgemap', ['skillcategories' => $skillcategories, 'skills' => $skills, 'grades' => $grades, 'discipline' => $discipline, 'oldgradeid' => $grade_id]);
    }

    /*** Show the form for creating a new discipline.
     ** return Illuminate\View\View
     */
    public function create ()
    {
        $curricula = Curriculum::pluck ('curriculum_gradelist_name', 'id')->all ();
        $languagePreferences = Language::pluck ('language', 'id')->all ();
        $tags = Discipline::existingTags ()->pluck ('name');
        $topics=Topic::pluck ( 'topic_name' ,'id')->all();
        return view ('disciplines.create', compact ('curricula', 'languagePreferences', 'tags' ,'topics'));
    }

    /*** list all Disciplines for Admin
     */
    public function listall (Request $request)
    {
        //$request->user()->authorizeRoles(['Admin']);
        $disciplines = Discipline::all ();
        return view ('disciplines.listall', compact ('disciplines'));
    }

    /**
     * Get the request's data from the request.
     */
    protected function getData (Request $request)
    {
        $rules = [
            'discipline_name'  => 'required|string|min:1|max:500',
            'description' => 'required|string|min:1|max:500',
            'curriculum_gradelist_id' => 'nullable',
            'group_id' => 'required|numeric|min:0|max:4294967295',
            'iconurl' => 'nullable|string|min:1|max:50',
            'color' => 'nullable|string|min:1|max:50',
            'language_preference_id' => 'required|exists:languages,id|numeric|min:0|max:4294967295',
            'topic_id' => 'required|exists:topics,id|min:0|max:4294967295',
            'approve_status' => 'required',
            'publish_status' => 'required',
            'createdby' => 'required|numeric|min:1|max:2147483647',
            'updatedby' => 'required|numeric|min:1|max:2147483647',
        ];


        $data = $request->validate ($rules);

        return $data;
    }


    /*** Show the form for editing the specified discipline.
     */
    public function edit ($id)
    {
        $discipline = Discipline::findOrFail ($id);
        $curricula = Curriculum::pluck ('curriculum_gradelist_name', 'id')->all ();
        $languagePreferences = Language::pluck ('language', 'id')->all ();
        $concatenated = "sting";//$discipline->tagNames();
        return view ('disciplines.edit', compact ('discipline', 'curricula', 'languagePreferences', 'concatenated'));
    }



    /** Remove the specified discipline from the storage.
     ** param  int $id
     ** return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {   $data['discipline_id'] = $id;

        $validator = $this->id_validation ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);
        }

            $discipline = Discipline::findOrFail ($id);
            $discipline->delete ();
        $responce = $this->rendererrorresponse ("204:successfully removed");
        return json_encode ($responce);
      //  return  response()->json(null, 204);
    }

    protected function disciplinevalidation (array $data)
    {
        return Validator::make (
            $data,
            [   'discipline_name' => 'required',
                'description' => 'required',

                'topic_id' => 'required|exists:topics,id|numeric|min:0|max:4294967295',
                'language_preference_id' => 'required|exists:languages,id|numeric|min:0|max:4294967295',
                'createdby' => 'required|exists:users,id|numeric|min:1|max:2147483647',
                'updatedby' => 'required|exists:users,id|numeric|min:1|max:2147483647',
                'approve_status' => 'required',
                'publish_status' => 'required',



            ], $this->messagevalidation ()
        );
    }


    protected function id_validation (array $data)
    {
        return Validator::make (
            $data,
            [
                'discipline_id' => 'required|exists:disciplines,id|numeric|min:0|max:4294967295',

            ], $this->messagevalidation ()
        );
    }



    private function messagevalidation ()
    {

        return $messages = array(

            'discipline_name.required' => '101:Empty discipline_name.',
            'description.required' => '101:Empty description.',
            'discipline_id.required' => '101:Empty discipline id.',
            'discipline_id.exists' => '101: discipline_id id is not exist',
            'language_preference_id.required' => '101:Empty language id.',
            'language_preference_id.exists' => '101: language_preference_id id is not exist',
            'topic_id.required' => '101:Empty topic id.',
            'topic_id.exists' => '101: topic_id is not exist',
            'createdby.required' => '101:Empty Created by.',
            'updatedby.required' => '101:Empty Updated by.',
            'approve_status.required' => '101:Empty Approve Status (default:pending).',
            'publish_status.required' => '101:Empty Publish Status (default:unpublished).',
            );


    }

    private function rendererrorresponse ($message)

    {
        $data = array();
        $errorid = substr ($message, 0, 3);
        $errortext = substr ($message, 4);
        $response = array();
        $response['status'] = $errorid;
        $response['message'] = $errortext;
      //  $response['data'] = $data;
        return $response;


    }


}
