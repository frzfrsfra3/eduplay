<?php
namespace App\Http\Controllers\User;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendingtask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
class PendingtasksController extends Controller {

    /**
     * Display a listing of the pendingtasks.
     *
     * return Illuminate\View\View
     */
    public function index() {
        $pendingtasks = Pendingtask::with('user', 'sender')->where('task_type', 0)->paginate(25);
        return view('pendingtasks.old.index', compact('pendingtasks'));
    }

    /**
     * My Pending tasks list
     * 
     * return Illuminate\View\View
     */
    public function mylist() {

        $user = Auth::user();
        
        $pendingtaskData = $this->pendingtasksFilterData();

        if(request('SortBy_search') === 'Descending'){
          $pendingtaskData = $this->allTaskFilterSortByDesc($pendingtaskData);
        } else if(request('SortBy_search') === 'Ascending') {
          $pendingtaskData = $this->allTaskFilterSortByAsc($pendingtaskData);
        } else {

          $pendingtasks = $this->paginate($pendingtaskData, 20);
        }

        return view('pendingtasks.mypendingtasks', compact('pendingtasks'));
    }


     /**
     * Added filter sort by filter type.
     * 
     * 
     */
    public function allTaskFilterSortByDesc($filter_task){
      if(request('filter_search') === 'description' ){
        $descData = collect($filter_task)->sortByDesc(function ($class_value, $key) {
           return $class_value['pending_task_description'];
        });
      } else if(request('filter_search') === 'sender'){
        $descData = collect($filter_task)->sortByDesc(function ($class_value, $key) {
          return $class_value['sender']['name'];
        });
      } else {
        $descData = $filter_task;
      }

      return $descData;
    }

     /**
     * Added filter sort by filter type.
     * 
     * 
     */
    public function allTaskFilterSortByAsc($filter_task){

      if(request('filter_search') === 'description' ){
        $ascData = collect($filter_task)->sortBy(function ($class_value, $key) {
            return $class_value->discipline['pending_task_description'];
        });
      } else if(request('filter_search') === 'sender'){
        $ascData = collect($filter_task)->sortBy(function ($class_value, $key) {
          return $class_value['sender']['name'];
        });
      } else {
        $ascData = $filter_task;
      }
      return $ascData;
    }


    /**
     * Show the form for creating a new pendingtask.
     *
     * return Illuminate\View\View
     */
    public function create() {
        $users = User::pluck('id', 'id')->all();
        $senders = User::pluck('id', 'id')->all();
        return view('pendingtasks.create', compact('users', 'senders'));
    }

    /**
     * Store a new pendingtask in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        try {
            $data = $this->getData($request);
            Pendingtask::create($data);
            return redirect()->route('pendingtasks.pendingtask.index')->with('success_message', 'Pendingtask was successfully added!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified pendingtask.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id) {
        $pendingtask = Pendingtask::with('user', 'sender')->findOrFail($id);
        return view('pendingtasks.show', compact('pendingtask'));
    }

    /**
     * Show the form for editing the specified pendingtask.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id) {
        $pendingtask = Pendingtask::findOrFail($id);
        $users = User::pluck('id', 'id')->all();
        $senders = User::pluck('id', 'id')->all();
        return view('pendingtasks.edit', compact('pendingtask', 'users', 'senders'));
    }

    /**
     * Update the specified pendingtask in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *'
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request) {
        try {
            $data = $this->getData($request);
            $pendingtask = Pendingtask::findOrFail($id);
            $pendingtask->update($data);
            return redirect()->route('pendingtasks.pendingtask.index')->with('success_message', 'Pendingtask was successfully updated!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified pendingtask from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        try {
            $pendingtask = Pendingtask::findOrFail($id);
            $pendingtask->delete();
            return redirect()->route('pendingtasks.pendingtask.index')->with('success_message', 'Pendingtask was successfully deleted!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Get the request's data from the request.
     *
     * param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData(Request $request) {
        $rules = ['user_id' => 'required', 'sender_id' => 'required', 'pending_task' => 'required|string|min:1|max:250', 'status' => 'required', ];
        $data = $request->validate($rules);
        return $data;
    }

    /**
     *
     * Develop by wc
     *
     * Pending task filter blade retrive.
     *
     * param Illuminate\Http\Request $request
     * return Illuminate\View\View
     */
    public function mylistFilter(Request $request) {
        //return $request->all();
        $pendingtaskData = $this->pendingtasksFilterData();

        if(request('SortBy_search') === 'Descending'){
          $pendingtaskData = $this->allTaskFilterSortByDesc($pendingtaskData);
        } else {
          $pendingtaskData = $this->allTaskFilterSortByAsc($pendingtaskData);
        } 
        $pendingtasks = $this->paginate($pendingtaskData, 20);


        return view('pendingtasks.filter-pendingtask', compact('pendingtasks'))->render();
    }
    
    /**
     *
     * Get fitered Pending task.
     *
     * param Illuminate\Http\Request $request
     * return Illuminate\View\View
     */
    protected function pendingtasksFilterData() {

        $user = Auth::user();
        $pendingtasks = Pendingtask::where('user_id', Auth::user()->id);
        //->where('task_type', '0');
        // Task Description search
        if (!empty(request('Description_search'))) {
            //dd(request('Description_search'));
            if (request('Description_operator') === 'like') {
                $pendingtasks->where('pending_task_description', 'LIKE', '%' . request('Description_search') . '%');
            } else {
                $pendingtasks->where('pending_task_description', '=', request('Description_search'));
            }
        }
        
        //Status search
        if(request('Status_search') != ''){            
            $pendingtasks->where('status', '=', request('Status_search'));
        } else {
            $pendingtasks->where('status', '=', 'pending');
        }

        //Fetch Data by created date.
        if (!empty(request('start_date'))) {
            $startDate = Carbon::parse(request('start_date'))->format('Y-m-d') . " 00:00:00";
            $endDate = Carbon::parse(request('end_date'))->format('Y-m-d') . " 23:59:59";
            $pendingtasks->whereBetween('created_at', [$startDate, $endDate]);
        }
        //Sorting Data by order.
        if (!empty(request('Sort_search')) && request('Sort_search') !== 'Descending') {
            $pendingtasks->orderBy('created_at', 'asc');
        } else {
            $pendingtasks->orderBy('created_at', 'desc');
        }
        //Fetch Data by Sender name.
        if (!empty(request('Sender_search'))) {
            if (request('Sender_search') === 'N/A') {
                $pendingtasks->where('sender_id', '=', '0');
            } else {
                $userName = request('Sender_search');
                $user = User::where('name', 'LIKE', '%' . $userName . '%')->first()->id;
                if ($user) {
                    if (request('sender_id') === 'like') {
                        $pendingtasks->where('sender_id', 'LIKE', '%' . $user . '%');
                    } else {
                        $pendingtasks->where('sender_id', '=', $user);
                    }
                }
            }
        }

        return $pendingtasks->get();
        // return $pendingtasks->paginate(20);
    }
}
