<?php
namespace App\Http\Controllers\User;
use App\Models\Discipline;
use App\Models\Inviteduser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Models\User;
use App\Mail\InviteFriendMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendInvitationEmail;
use Illuminate\Support\Carbon;
use App\Http\Traits\AddXppoint;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Mail\InviteUsers;
use App\Models\Pendingtask;

class InvitedusersController extends Controller {

    use AddXppoint;

    /**
     * Display a listing of the invitedusers.
     *
     * return Illuminate\View\View
     */
    public function index() {
        $invitedusers = Inviteduser::paginate(25);
        return view('invitedusers.index', compact('invitedusers'));
    }

    /**
     * Show the form for creating a new inviteduser.
     *
     * return Illuminate\View\View
     */
    public function create() {
        $disciplines = Discipline::pluck('discipline_name', 'id')->all();
        return view('invitedusers.create', compact('disciplines'));
    }

    /**
     * Store a new inviteduser in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        try {
            $data = $this->getData($request);
            Inviteduser::create($data);
            return redirect()->route('invitedusers.inviteduser.index')->with('success_message', 'Inviteduser was successfully added!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * invite friend / from progile -invite friend
     * param Illuminate\Http\Request $request
     * return Illuminate\View\View
     */
    public function store_profile(Request $request) {
        try {
            $data = $this->getData($request);
            $sender = User::findorfail($data['invitedby']);
            $user = User::where('email', '=', $data['email'])->first();
            if ($user) {
                $alreadyregistredtext = Lang::get('user.alreadyregisteredtext');
                return back()->withInput()->withErrors(['already registered' => $alreadyregistredtext]);
            } else {
                $inviteduser = Inviteduser::where('email', '=', $data['email'])->where('invitedby', '=', $data['invitedby'])->where('invitationtype', '=', $data['invitationtype'])->first();
                if ($inviteduser) {
                    $alreadyinvitedtext = Lang::get('user.alreadyinvited');
                    return back()->withInput()->withErrors(['already invited' => $alreadyinvitedtext]);
                } else {
                    $this->add_xp_point(Auth::user()->id, 'Invitefriend');
                    $inviteduser = Inviteduser::create($data);
                    $job = (new SendInvitationEmail('SDSDSD', $sender, $inviteduser))->delay(Carbon::now()->addSeconds(120));
                    $this->dispatch($job);
                    //    Mail::to ($data['email'])->queue (new InviteFriendMail (  'SDSDSD', $sender ,$inviteduser));
                    return back()->withInput()->with('success_message', 'Inviteduser was successfully added!');
                }
            }
        }
        catch(Exception $exception) {
            Storage::disk('local')->append('jobsendingmail_error.txt', $exception);
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified inviteduser.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id) {
        $inviteduser = Inviteduser::with('discipline')->findOrFail($id);
        return view('invitedusers.show', compact('inviteduser'));
    }

    /**
     * Show the form for editing the specified inviteduser.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id) {
        $inviteduser = Inviteduser::findOrFail($id);
        $disciplines = Discipline::pluck('discipline_name', 'id')->all();
        return view('invitedusers.edit', compact('inviteduser', 'disciplines'));
    }

    /**
     * Update the specified inviteduser in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request) {
        try {
            $data = $this->getData($request);
            $inviteduser = Inviteduser::findOrFail($id);
            $inviteduser->update($data);
            return redirect()->route('invitedusers.inviteduser.index')->with('success_message', 'Invited user is successfully updated!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified inviteduser from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        try {
            $inviteduser = Inviteduser::findOrFail($id);
            $inviteduser->delete();
            return redirect()->route('invitedusers.inviteduser.index')->with('success_message', 'Inviteduser was successfully deleted!');
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
        $rules = ['email' => 'required|string|min:1|max:250', 'invitedby' => 'required|numeric|min:-2147483648|max:2147483647', 'message' => 'nullable', 'invitationtype' => 'required', 'invitationstatus' => 'required', 'isinvitedregistered' => 'boolean', 'discipline_id' => 'nullable', ];
        $data = $request->validate($rules);
        $data['isinvitedregistered'] = $request->has('isinvitedregistered');
        return $data;
    }
    
    /**
     *
     * Develop by WC
     *
     * Invite child reset dynamic password.
     *
     * return Illuminate\View\View
     *
     */
    public function childResetPassword() {
        if (Auth::user()) {
            $child = User::findorfail(Auth::user()->id);
            if ($child->child_password_reset === 1) {
                return redirect()->route('users.user.profile', ['id' => $child->id]);
            }
            return view('eduplaycloud.users.child-password');
        } else {
            return redirect()->route('home')->with('success_message', 'Invited child login first!');
        }
    }

    /**
     *
     * Develop by WC
     *
     * Invite Multiple user ( Initial Task )
     *
     */
    public function inviteUsers(Request $request) {
        $emails= array_filter($request->email);
        $user=User::whereIn('email',$emails)->pluck('email');
        $reguser = $user->toArray();
        $user=Auth::user()->name;
        $auth_email=Auth::user()->email;

        foreach($reguser as $ruser){
            if (in_array($ruser, $emails))
            {
                unset($emails[array_search($ruser,$emails)]);
            }
        }

        //dd($emails);
        if(!empty($emails)){
            Mail::bcc($emails)->send(new InviteUsers($user));
            if (Mail::failures()) {
                return redirect()->route('exercisesets.exerciseset.private')->with('error_message', Lang::get('messages.mail_send_unsuccessfully'));
            } else {
                $task= Pendingtask::where('user_id','=',Auth::user ()->id)
                ->where ('pending_task_description','=','Invite Your Friend To Use Eduplaycloud')
                ->first();
                if ($task)
                {
                    $task->status='done';
                    $task->task_type=1;
                    $task->save();
                }
                $this->add_xp_point (Auth::user()->id,'invitefriend');
                return redirect()->route('exercisesets.exerciseset.private')->with('success_message', Lang::get('messages.invitation_send_successfully'));
            }
        } else {
            return redirect()->route('exercisesets.exerciseset.private')->with('error_message', Lang::get('messages.invitation_not_send_on_same_account'));
        }
    }
}
