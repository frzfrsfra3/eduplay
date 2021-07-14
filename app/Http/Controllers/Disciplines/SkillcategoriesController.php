<?php

namespace App\Http\Controllers\Disciplines;

use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Models\Skillcategory;
use App\Models\Disciplineversion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Exception;

class SkillcategoriesController extends Controller
{

    /**
     * Display a listing of the skillcategories.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $skillcategories = Skillcategory::with('discipline')->paginate(25);

        return view('skillcategories.index', compact('skillcategories'));
    }

    /**
     * Show the form for creating a new skillcategory.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        $disciplines = Discipline::pluck('discipline_name','id')->all();
        
        return view('skillcategories.create', compact('disciplines'));
    }

    /**
     * Store a new skillcategory in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $id_form = $request->input('id_from');
            if (  $id_form =='1') {

                $data = $this->getDataModal($request);
                $data['createdby']=Auth::user ()->id;
                $data['updatedby']=0;
                $data['publish_status']='unpublished';
                $data['approve_status']='pending';
                $data['version']= $this->getlastpublishedversion ( $data['discipline_id'])+1;
                $skillcategory  = Skillcategory::create($data);
                $message_text1 = 'the skill ' . $data['skill_category_name'] . ' was successfully created! ';
                return redirect ()->route ('collaboration.index', $data['discipline_id'] )->with ('skill_category_id', $skillcategory->id )->with ('message_text', $message_text1);

            }

            else if ($id_form =='2') {


                $data = $this->getDataModal($request);
                $data['updatedby']=Auth::user ()->id;
                $data['publish_status']='unpublished';
                $data['approve_status']='pending';
                $nav_id=$data['origin_id'];

                $child_skillcategory=Skillcategory::Where([['origin_id','=', $data['origin_id']],['updatedby','=',Auth::user ()->id]])->first();

                if ($child_skillcategory)  {
                    $data['version']= $this->getlastpublishedversion ( $data['discipline_id'])+1;
                    $skillcategory = Skillcategory::findOrFail($child_skillcategory->id);
                    $skillcategory->update($data);
                }
                else {
                    $origin_skill=Skillcategory::Where('id','=', $data['origin_id'])->first();
                    $data['createdby']=$origin_skill->createdby;
                    $skillcategory = Skillcategory::findOrFail($data['origin_id']);

                    if ( $skillcategory->version == ($this->getlastpublishedversion ( $data['discipline_id'] ) ))
                    {
                        $data['version']= $this->getlastpublishedversion ( $data['discipline_id'])+1;
                        $skillcategory::create($data);
                    }
                    else {
                        $skillcategory = Skillcategory::findOrFail($data['origin_id']);
                        $data['origin_id']=0;
                        $skillcategory->update($data);
                    }
                }
                $message_text1 = 'the skill category' . $data['skill_category_name'] . ' was edited ! ';
                return redirect ()->route ('collaboration.index', $data['discipline_id'])->with ('skill_category_id',  $data['origin_id'] )->with ('message_text', $message_text1);
            }
            else {
                $data = $this->getData($request);
                Skillcategory::create($data);


            return redirect()->route('skillcategories.skillcategory.index')
                             ->with('success_message', 'Skillcategory was successfully added!'); }

       } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified skillcategory.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $skillcategory = Skillcategory::with('discipline')->findOrFail($id);

        return view('skillcategories.show', compact('skillcategory'));
    }

    /**
     * Show the form for editing the specified skillcategory.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $skillcategory = Skillcategory::findOrFail($id);
        $disciplines = Discipline::pluck('discipline_name','id')->all();

        return view('skillcategories.edit', compact('skillcategory','disciplines'));
    }

    /**
     * Update the specified skillcategory in the storage.
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
            
            $skillcategory = Skillcategory::findOrFail($id);
            $skillcategory->update($data);

            return redirect()->route('skillcategories.skillcategory.index')
                             ->with('success_message', 'Skillcategory was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified skillcategory from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $skillcategory = Skillcategory::findOrFail($id);
            $skillcategory->delete();

            return redirect()->route('skillcategories.skillcategory.index')
                             ->with('success_message', 'Skillcategory was successfully deleted!');

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
        $rules = [
            'discipline_id' => 'required',
            'description_Fr' => 'nullable',
            'description_Ar' => 'nullable',
            'skill_category_name' => 'required|string|min:1|max:250',
            'skill_category_decsription' => 'required|string|min:1|max:500',
            'version' => 'required|numeric|min:-2147483648|max:2147483647',
            'sort_order' => 'required|numeric|min:-2147483648|max:2147483647',
            'approve_status' => 'required',
            'publish_status' => 'required',
            'createdby' => 'required|numeric|min:-2147483648|max:2147483647',
            'updatedby' => 'required|numeric|min:-2147483648|max:2147483647',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }


    protected function getDataModal(Request $request)
    {
        // dd('i a, here');
        $rules = [
            'discipline_id' => 'required',
            'skill_category_name' => 'required|string|min:1|max:250',
            'skill_category_decsription' => 'required|string|min:1|max:500',
            'sort_order' => 'required|numeric|min:-2147483648|max:2147483647',
            'origin_id' => 'nullable|numeric|min:-2147483648|max:2147483647',

        ];

        $data = $request->validate($rules);





        return $data;
    }

    private function  getlastpublishedversion ($discipline_id){


        $currentpublishedversion =Disciplineversion::where ('discipline_id', '=', $discipline_id)->max ('version');
        return $currentpublishedversion;

    }

}
