<?php

namespace App\Http\Controllers\Disciplines;

use App\Models\Skill;
use App\Models\Topic;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Models\Skillcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Disciplineversion;
use Exception;

class SkillsController extends Controller
{

    /**
     * Display a listing of the skills.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $skills = Skill::with('skillcategory','topic','grade')->paginate(25);
        return view('skills.index', compact('skills'));
    }

    /**
     * Show the form for creating a new skill.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        $skillcategories = Skillcategory::all('skill_category_name','id')->all();
        $topics = Topic::pluck('topic_name','id')->all();
        $grades = Grade::pluck('grade_name','id')->all();

        return view('skills.create', compact('skillcategories','topics','grades'));
    }


    /**
     * Store a new skill in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request )
    {

			try{

						$id_form = $request->input('id_from');
						if (  $id_form =='1') {
						$data = $this->getDataModal($request);
								$data['createdby']=Auth::user ()->id;
								$data['updatedby']=0;
								$data['publish_status']='unpublished';
								$data['approve_status']='pending';
								$data['version']= $this->getlastpublishedversion ( $data['skill_category_id'])+1;

								Skill::create($data);
								$skillcategory = Skillcategory::findOrFail ($data['skill_category_id']);
								$message_text1 = 'the skill ' . $data['skill_name'] . ' was successfully created! ';
								return redirect ()->route ('collaboration.index', $skillcategory->discipline_id)->with ('skill_category_id', $data['skill_category_id'] )->with ('message_text', $message_text1);

            }
            else if ( $id_form =='2' ) {

                $data = $this->getDataModal($request);
                $data['updatedby']=Auth::user ()->id;
                $data['publish_status']='unpublished';
                $data['approve_status']='pending';


               $child_skill=skill::Where([['origin_id','=', $data['origin_id']],['updatedby','=',Auth::user ()->id]])->first();

                if ($child_skill)  {
                    $data['version']= $this->getlastpublishedversion ( $data['skill_category_id'])+1;
                    $skill = Skill::findOrFail($child_skill->id);
                    $skill->update($data);
                    $spanid='span'.$child_skill->id;
                }
                else {
                    $origin_skill=skill::Where('id','=', $data['origin_id'])->first();

                    $data['createdby']=$origin_skill->createdby;
                    $skill = Skill::findOrFail($data['origin_id']);
                    if ( $skill->version == ($this->getlastpublishedversion ( $data['skill_category_id'])) )
                    {
                    $data['version']= $this->getlastpublishedversion ( $data['skill_category_id'])+1;
                    Skill::create($data);
                        $spanid='';
                    }
                    else {
                        $skill = Skill::findOrFail($data['origin_id']);
                        $data['origin_id']=0;
                        $spanid='i'.$skill->id;
                        $skill->update($data);
                    }
                }

                $skillcategory = Skillcategory::findOrFail ($data['skill_category_id']);
                $message_text1 = 'the skill ' . $data['skill_name'] . ' was edited ! ';

              return redirect ()->route ('collaboration.index', $skillcategory->discipline_id)->with ('skill_category_id', $data['skill_category_id'] )->with ('message_text', $message_text1);

            }
        else {
			// dd($request->all());
			$data = $this->getData($request);

            Skill::create($data);

                return redirect ()->route ('skills.skill.index')
										->with ('success_message', 'Skill was successfully added!');  
				}
    }
 catch (Exception $exception) {

         return back()->withInput()
                      ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
     }
    }

    /**
     * Display the specified skill.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $skill = Skill::with('skillcategory','topic','grade')->findOrFail($id);

        return view('skills.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified skill.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        $skillcategories = Skillcategory::all('skill_category_name','id')->all();
		$topics = Topic::pluck('topic_name','id')->all();
        $grades = Grade::pluck('grade_name','id')->all();

        return view('skills.edit', compact('skill','skillcategories','topics','grades'));
    }

    /**
     * Update the specified skill in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $skill = Skill::findOrFail($id);
            $skill->update($data);

            return redirect()->route('skills.skill.index')
                             ->with('success_message', 'Skill was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified skill from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $skill = Skill::findOrFail($id);
            $skill->delete();

            return redirect()->route('skills.skill.index')
                             ->with('success_message', 'Skill was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * param Illuminate\Http\Request\Request $request 
     * return array
     */
    protected function getData(Request $request)
    {
       // dd('i a, here');
        $rules = [
            'skill_category_id' => 'required|numeric|min:|max:2147483647',
            'topic_id' => 'nullable|numeric|min:-2147483648|max:2147483647',
            'grade_id' => 'nullable|numeric|min:-2147483648|max:2147483647',
            'skill_name' => 'required|string|min:1|max:250',
			'skill_description' => 'required|string|min:1|max:500',
			'description_Fr' => 'nullable|string',
            'description_Ar' => 'nullable|string',
            'version' => 'required|numeric|min:-2147483648|max:2147483647',
            'publish_status' => 'required|string|min:1|max:500',
            'approve_status' => 'required|string|min:1|max:500',
            'createdby' => 'required|numeric|min:-2147483648|max:2147483647',
            'updatedby' => 'required|numeric|min:-2147483648|max:2147483647',
            'sort_order' => 'nullable|numeric|min:-2147483648|max:2147483647',
     
        ];

   //     dd($request);
        $data = $request->validate($rules);

      //    dd($data);



        return $data;
    }

    protected function getDataModal(Request $request)
    {

        $rules = [
            'skill_category_id' => 'required',
            'topic_id' => 'nullable',
            'grade_id' => 'nullable',
            'skill_name' => 'required|string|min:1|max:250',
            'skill_description' => 'required|string|min:1|max:500',
            'sort_order' => 'nullable|numeric|min:-2147483648|max:2147483647',
            'origin_id' => 'nullable|numeric|min:-2147483648|max:2147483647',

        ];


        $data = $request->validate($rules);





        return $data;
    }
    private function  getlastpublishedversion ($skill_category_id){


        $skill_category=Skillcategory::where('id',$skill_category_id)->first ();

        $discipline_id=$skill_category->discipline_id;
        $currentpublishedversion = Disciplineversion::where ('discipline_id', '=', $discipline_id)->max ('version');
        return $currentpublishedversion;

}

}
