<?php

namespace App\Http\Controllers\Parent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ParentRequest;
use App\Models\Pendingtask;
use App\Models\Usernotification;

class ParentRequestsController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('eduplaycloud.users.add-existing-children');
    }

    /**
     * Store a newly created resource in storage.
     *
     * param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $childEmailOrUsername = $request->input('email_or_user');

        $succeed = false;
        $error = "";

        // check if the user is parent
        $currentUser = auth()->user();
        if ( $currentUser->hasRole('Parent'))
        {
            $child = User::where('email' , $childEmailOrUsername)->first();

            // check if is exist
            if ( $child )
            {
                // Check the child
                if ( !$child->hasRole("Learner")) 
                    $error = "User you are trying to link as a child is not a learner!";

                // Check if the user is already have a parent
                else if ( $child->parent_id != null )
                {

                    if ( $child->parent_id == $currentUser->id )
                        $error = "User you are trying to link is already linked with your account!";
                    else 
                        $error = "User you are trying to link is already linked to another parent!";
                }
                else 
                {
                    // Check if parent already sent a request to this child
                    $parentRequestsCount = ParentRequest::where([
                        'parent_id' => $currentUser->id,
                        'child_id' => $child->id
                    ])->get()->count();

                    if ( $parentRequestsCount > 0)
                        $error = "You already sent a parent request!";
                    else 
                    {
                        // Sending ParentRequest to to learner
                        $parentRequest = new ParentRequest;
                        $parentRequest->parent_id = $currentUser->id;
                        $parentRequest->child_id = $child->id;
                        $parentRequest->save();
                        
                        // Create Task for child
                        $pendingTask = new Pendingtask;
                        $pendingTask->user_id = $child->id;
                        $pendingTask->sender_id = $currentUser->id;

                        // Description must be the same in filter-pendingtask view
                        $pendingTask->pending_task_description = "Accept parent request";

                        // Store Parent Request ID in action field => to use it in view to generate approve link
                        $pendingTask->pending_task_action = $parentRequest->id;

                        // Set status as pending
                        $pendingTask->status = "Pending";

                        // Set status to default value => I don't know why (^_^)
                        $pendingTask->task_type = 0;

                        $pendingTask->save();

                        $succeed = true;
                    }
                }
            }
            else 
                $error = "Email or username that you entered is not valid!";
        }
        else
            $error = "You are not a parent!";

        if ( $succeed )
            return redirect(route('users.user.profile', $currentUser))->with('success_message', "Request sent successfully to your child, let your child check the profile section and approve your request! .");
        else 
            return redirect()->back()->with('error_message', $error);
    }

    public function approve($id)
    {

        $parentRequest = ParentRequest::find($id);
        $succeed = false;
        $error = "";

        $currentUser = auth()->user();
        if ( $parentRequest )
        {
            // check IDs
            if ( $parentRequest->child_id == $currentUser->id )
            {
                $currentUser->parent_id = $parentRequest->parent_id;
                $currentUser->parentMail = $parentRequest->parent->email;
                $currentUser->save();
                $parentRequest->approved = true;
                $parentRequest->save();

                // Set task as done
                $pendingTask = Pendingtask::where('pending_task_action' , $parentRequest->id)->get()->first();
                if ( $pendingTask )
                {
                    $pendingTask->status = "done";
                    $pendingTask->save();
                }

                $succeed = true;
            }
            else 
                $error = "Unauthorized";
        }
        else 
            $error = "Not Found";

        if ( $succeed )
            return redirect(route('users.user.profile', $currentUser))->with('success_message', "Request has been approved, " . $parentRequest->parent->name . " is set as your parent!");
        else 
            return redirect()->back()->with('error_message', $error);
    }

    /**
     * Display the specified resource.
     *
     * param  int  $id
     * return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * param  int  $id
     * return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * param  int  $id
     * return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
