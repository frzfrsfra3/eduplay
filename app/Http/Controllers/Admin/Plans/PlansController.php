<?php

namespace App\Http\Controllers\Admin\Plans;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use App\Models\PlanOption;
use App\Models\Option;
use App\Models\Role;

class PlansController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        $this->photos_path = public_path('/images');
        
    }


    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index() {
        if (Auth::user()->hasRole('Admin')) 
        {
            $plans = Plan::paginate(25);
            return view('admin-side.plans.index', compact('plans'));
        } 
        else
            return view('unauthorized');
    }

    /**
     * Show the form for creating a new resource.
     *
     * return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( !auth()->user()->hasRole('Admin') )
            return view('unauthorized');

        $roles = Role::all();
        return view('admin-side.plans.create' , compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ( !auth()->user()->hasRole('Admin') )
            return view('unauthorized');

        // Validate
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'visibility' => 'required',
            'role_id' => 'required',
        ]);

        // Store
        $plan = new Plan;
        $plan->name = $request->input('name');
        $plan->description = $request->input('description');
        $plan->price = $request->input('price');
        $plan->visibility = $request->input('visibility');
        $plan->role_id = $request->input('role_id');
        $plan->save();
        return redirect(route('plans.show' ,  $plan->id))->with('success' , 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * param  int  $id
     * return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( !auth()->user()->hasRole('Admin') )
            return view('unauthorized');

        // Classify options by category
        $options = [];
        $optionsRocords = Option::all();
        foreach ($optionsRocords as $record) {
            $options[$record->category][$record->id] = $record->label;
        }

        // Get all roles
        $roles = Role::all();

        // Find Plan
        $plan = Plan::findOrFail($id);

        return view('admin-side.plans.show' , compact('plan' , 'options' , 'roles'));

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * param  int  $id
     * return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // integrated with show
    }

    /**
     * Update the specified resource in storage.
     *
     * param  \Illuminate\Http\Request  $request
     * param  int  $id
     * return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ( !auth()->user()->hasRole('Admin') )
            return view('unauthorized');

        // Validate
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'visibility' => 'required',
            'role_id' => 'required',
        ]);

        // Store
        $plan = Plan::findOrFail($id);
        $plan->name = $request->input('name');
        $plan->description = $request->input('description');
        $plan->price = $request->input('price');
        $plan->visibility = $request->input('visibility');
        $plan->role_id = $request->input('role_id');
        $plan->save();
        return redirect(route('plans.show' ,  $plan->id))->with('success' , 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * param  int  $id
     * return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( !auth()->user()->hasRole('Admin') )
            return view('unauthorized');

        $plan = Plan::findOrFail($id);
        foreach ($plan->plan_options as $plan_option) {
            $plan_option->delete();
        }
        $plan->delete();
        return redirect(route('plans.index'))->with('success' , 'Deleted Successfully');
    }

    public function insertPlanOption(Request $request)
    {
        if ( !auth()->user()->hasRole('Admin') )
            return view('unauthorized');

        $plan_id = $request->input('plan_id');
        $option_id = $request->input('opiton_id');
        $value = $request->input('value');

        $planOption = new PlanOption;
        $planOption->plan_id = $plan_id;
        $planOption->option_id = $option_id;
        $planOption->value = $value;
        $planOption->save();

        return redirect(route('plans.show' , [$plan_id]));
    }

    public function updatePlanOption(Request $request)
    {
        if ( !auth()->user()->hasRole('Admin') )
            return view('unauthorized');

        $plan_option_id = $request->input('plan_option_id');
        $value = $request->input('value');
        $planOption = PlanOption::findOrFail($plan_option_id);
        $planOption->value = $value;
        $planOption->save();

        return redirect(route('plans.show' , [$planOption->plan_id]));
    }

    public function deletePlanOption(Request $request)
    {
        if ( !auth()->user()->hasRole('Admin') )
            return view('unauthorized');
            
        $plan_option_id = $request->input('plan_option_id');
        $planOption = PlanOption::findOrFail($plan_option_id);
        $plan_id = $planOption->plan_id;
        $planOption->delete();
        return redirect(route('plans.show' ,  $plan_id));

    }
}
