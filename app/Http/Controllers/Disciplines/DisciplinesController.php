<?php

namespace App\Http\Controllers\Disciplines;

use App\Http\Controllers\Controller;
use App\Models\Discipline;
use App\Models\Curriculum;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Disciplineversion;
use App\Models\Country;
use App\Models\Skillcategory;
use App\Models\Skill;
use App\Models\Grade;

use Illuminate\Support\Facades\DB;

//use Exception;

class DisciplinesController extends Controller
{
    //index, create, store, show, edit, update, destroy, getData
    //filter_country_id, getknwoledgemap, listall,

    /**
     * Display a listing of the Disciplines Curricula from table disciplines.
     */
    public function index ()
    {
        // fetch with any tag listed....
        if (isset($_GET['searchkey'])) {
            $name = $_GET['searchkey'];
        } else {
            $name = '';
        }
        $disciplines = Discipline::with ('curriculum_gradelist', 'languagePreference')->where ([['discipline_name', 'like', '%' . $name . '%'], ['publish_status', 'like', 'published']])->orwhere ([['description', 'like', '%' . $name . '%'], ['publish_status', 'like', 'published']])->paginate (25);


        return view ('disciplines.index', compact ('disciplines'));
    }

    /**
     * filter the Disciplines
     */
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

    /**
     * Display all Skills and the Skills Category for a slected disicpilne by the last published  version
     */
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

    /**
     * Show the form for creating a new discipline.
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

    /**
    * Store a new discipline in the storage.
     */
    public function store (Request $request)
    {
        try {
          $data = $this->getData ($request);
            Discipline::create ($data);
            return redirect ()->route ('disciplines.discipline.listall')
                ->with ('success_message', 'Discipline was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * list all Disciplines Curricula for Admin
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
            'discipline_name' => 'required',
            'description' => 'required|string|min:1|max:500',
            'curriculum_gradelist_id' => 'nullable',
            'iconurl' => 'nullable|string|min:1|max:50',
            "tags" => 'nullable|string|min:1|max:50',
            "topic_id" => 'nullable|numeric|min:0|max:4294967295',
            'language_preference_id' => 'required|numeric|min:0|max:4294967295',
            'approve_status' => 'required',
            'publish_status' => 'required',
            'createdby' => 'required|numeric|min:1|max:2147483647',
            'updatedby' => 'required|numeric|min:1|max:2147483647',

        ];

        $data = $request->validate ($rules);
        return $data;
    }

    /**
     * Display the specified discipline curriculum.
     */
    public function show ($id)
    {
        $discipline = Discipline::with ('curriculum_gradelist', 'languagePreference')->findOrFail ($id);

        return view ('disciplines.show', compact ('discipline'));
    }

    /**
     * copy the specified discipline curriculum.
     */
    public function copy ($id)
    {
        $discipline = Discipline::with('skillcategories')->findOrFail($id);
        $data = $discipline->toArray();
          unset($data['id']);
          unset($data['created_at']);
          unset($data['updated_at']);
          
          $copyDiscipline = Discipline::create ($data);
        
          foreach($data['skillcategories'] as $skillcategories){
            $skillcategories['discipline_id'] = $copyDiscipline->id;
            unset($skillcategories['id']);
            unset($skillcategories['created_at']);
            unset($skillcategories['updated_at']);
              Skillcategory::create($skillcategories);
          }

        return redirect ()->route ('disciplines.discipline.listall')
            ->with ('success_message', 'Discipline was successfully copied!');
    }


    /**
     * Show the form for editing the specified discipline curriculum.
     */
    public function edit ($id)
    {
        $discipline = Discipline::findOrFail ($id);
        $curricula = Curriculum::pluck ('curriculum_gradelist_name', 'id')->all ();
        $languagePreferences = Language::pluck ('language', 'id')->all ();
        $concatenated = "sting";//$discipline->tagNames();
        $topics=Topic::pluck ( 'topic_name' ,'id')->all();
        return view ('disciplines.edit', compact ('discipline', 'curricula', 'languagePreferences', 'concatenated','topics'));
    }

    /**
     * Update the specified discipline curriculum in the storage.
     */
    public function update ($id, Request $request)
    {
        try {

            $data = $this->getData ($request);

            $discipline = Discipline::findOrFail ($id);
            $discipline->update ($data);
            $discipline->tag (explode (',', $request->tags));

            return redirect ()->route ('disciplines.discipline.listall')
                ->with ('success_message', 'Discipline was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified discipline curriculum from the storage.
     */
    public function destroy ($id)
    {
        try {
            $discipline = Discipline::findOrFail ($id);
            $discipline->delete ();

            return redirect ()->route ('disciplines.discipline.listall')
                ->with ('success_message', 'Discipline was successfully deleted!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

}
