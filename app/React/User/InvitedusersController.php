<?php

namespace App\React\User;


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


class InvitedusersController extends Controller
{

    use AddXppoint;
    /**
     * Display a listing of the invitedusers.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $invitedusers = Inviteduser::paginate (25);

        return view ('invitedusers.index', compact ('invitedusers'));
    }

    /**
     * Show the form for creating a new inviteduser.
     *
     * return Illuminate\View\View
     */
    public function create ()
    {
        $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();

        return view ('invitedusers.create', compact ('disciplines'));
    }

    /**
     * Store a new inviteduser in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Inviteduser::create ($data);

            return redirect ()->route ('invitedusers.inviteduser.index')
                ->with ('success_message', 'Inviteduser was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

// this function is used to invite friend / from progile -invite friend
    public function store_profile (Request $request)
    {


        try {

            $data = $this->getData ($request);
            $sender = User::findorfail ($data['invitedby']);
            $user = User::where ('email', '=', $data['email'])->first ();
            if ($user) {
                $alreadyregistredtext = Lang::get ('user.alreadyregisteredtext');
                return back ()->withInput ()
                    ->withErrors (['already registered' => $alreadyregistredtext]);
            } else {
                $inviteduser = Inviteduser::where ('email', '=', $data['email'])->where ('invitedby', '=', $data['invitedby'])
                    ->where ('invitationtype', '=', $data['invitationtype'])->first ();
                if ($inviteduser) {
                    $alreadyinvitedtext = Lang::get ('user.alreadyinvited');
                    return back ()->withInput ()
                        ->withErrors (['already invited' => $alreadyinvitedtext]);
                } else {
                    $this->add_xp_point(Auth::user ()->id ,'Invitefriend');
                    $inviteduser = Inviteduser::create ($data);
                    $job = (new SendInvitationEmail('SDSDSD', $sender, $inviteduser))->delay (Carbon::now ()->addSeconds (120));
                    $this->dispatch ($job);
                    //    Mail::to ($data['email'])->queue (new InviteFriendMail (  'SDSDSD', $sender ,$inviteduser));
                    return back ()->withInput ()->with ('success_message', 'Inviteduser was successfully added!');
                }
            }

        } catch (Exception $exception) {
            Storage::disk ('local')->append ('jobsendingmail_error.txt', $exception);
            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    /**
     * Display the specified inviteduser.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $inviteduser = Inviteduser::with ('discipline')->findOrFail ($id);

        return view ('invitedusers.show', compact ('inviteduser'));
    }

    /**
     * Show the form for editing the specified inviteduser.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {
        $inviteduser = Inviteduser::findOrFail ($id);
        $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();

        return view ('invitedusers.edit', compact ('inviteduser', 'disciplines'));
    }

    /**
     * Update the specified inviteduser in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update ($id, Request $request)
    {
        try {

            $data = $this->getData ($request);

            $inviteduser = Inviteduser::findOrFail ($id);
            $inviteduser->update ($data);

            return redirect ()->route ('invitedusers.inviteduser.index')
                ->with ('success_message', 'Inviteduser is successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified inviteduser from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {
        try {
            $inviteduser = Inviteduser::findOrFail ($id);
            $inviteduser->delete ();

            return redirect ()->route ('invitedusers.inviteduser.index')
                ->with ('success_message', 'Inviteduser was successfully deleted!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData (Request $request)
    {
        $rules = [
            'email' => 'required|string|min:1|max:250',
            'invitedby' => 'required|numeric|min:-2147483648|max:2147483647',
            'message' => 'nullable',
            'invitationtype' => 'required',
            'invitationstatus' => 'required',
            'isinvitedregistered' => 'boolean',
            'discipline_id' => 'nullable',

        ];


        $data = $request->validate ($rules);


        $data['isinvitedregistered'] = $request->has ('isinvitedregistered');


        return $data;
    }

}
