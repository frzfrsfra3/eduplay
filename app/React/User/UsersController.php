<?php

namespace App\React\User;

use App\Jobs\AddChildJob;
use App\Models\Inviteduser;
use App\Models\User;
use App\Models\Grade;
use App\Models\School;
use App\Models\Country;
use App\Models\Language;
use App\Http\Controllers\Controller;
use App\Models\Useractivitylog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use Illuminate\Support\Carbon;
//use Exception;
use Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Events\CompleteProfile;
use App\Http\Traits\AddXppoint;

class UsersController extends Controller
{
    use AddXppoint;

    public function __construct()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
    //    $this->middleware('auth');
        $this->photos_path = public_path ('/images');
    }

    /**
     * Display a listing of the users. only for admin
     ** return Illuminate\View\View
     */
    public function index()
    {

      if(  Auth::user()->hasRole('Admin')  ) {
        $users = User::paginate(25);

        return view('users.index', compact('users'));

      }
      else
          return view('unauthorized');
    }

    /** List Roles */
    public function editrole($id){
        $roles='';
        $user = User::findOrFail($id);
        return view('users.roles', compact('user','roles'));
    }

    // Show the form for creating a new user.
    public function create()
    {
        $providers = 'email';
        $grades = Grade::pluck('grade_name','id')->all();
        $schools = School::pluck('school_name','id')->all();
        $parents = User::pluck('name','id')->all();
        $countries = Country::pluck('country_name','id')->all();
        $uilanguages = Language::pluck('language','id')->all();

        return view('users.create', compact('providers','grades','schools','parents','countries','uilanguages'));
    }

    /**
     * Store a new user in the storage.
    */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);
            User::create($data);

            return redirect()->route('users.user.index')
                             ->with('success_message', 'User was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified user.
     ** param int $id
     ** return views/users/show
     */
    public function show($id)
    {
        $user = User::with('grade','school','country','uilanguage')->findOrFail($id);
        return view('users.show', compact('user'));
    }

    /*
     * Display the specified user profile.
     ** param int $id
     */
    public  function  getprofile($id)
    {
        $user = User::where('id', '=', $id)->first();

        $countries = Country::select('country_name', 'id')->get();
        $uilanguages = Language::select('language', 'id')->get();
        $grades = Grade::select('grade_name', 'id')->get();
        $lastuseractivitylogs = Useractivitylog::where('user_id', '=', $id)->orderBy("id", 'desc')->first();
       // $profile = User::where('id', '=', $user->id)->select('id', 'name', 'mobile', 'email', 'gender', 'country_id', 'grade_id', 'user_image', 'grade_id', 'school_id', 'uilanguage_id', 'dob', 'phone')->first();
        $user['countries']=$countries;
        $user['uilanguages']=$uilanguages;
        $user['grades']=$grades;
        return response()->json($user,200);


    }

    //get user badges??
    public function userbadges($id){
        if ($id==Auth::user ()->id || Auth::user()->hasRole(['Admin'])) {
            $user = User::findOrFail($id);
            return view('users.userbadges', compact('user'));
        }
        else
            return view('unauthorized');

    }

    public function parentapproval ($code){
        try {
            Storage::disk ('local')->append ('aprove.txt', 'aprove'.$code);

            $user=User::where('confirmation_code','=',$code)->first();
            if ($user )  return view ('users.parentapproval' ,compact ('user','code'));


            return view ('home');
            //   return ;
        } catch (Exception $exception) {
            Storage::disk ('local')->append ('aproveerror.txt', $exception);
        }

    }

    public function updatepicture($id ,Request $request ){
        try {

            Storage::disk ('local')->append ('uploadimage.txt','start' );
            Storage::disk ('local')->append ('uploadimage.txt',$request );

            if ($request->hasFile('upload-photo')) {
                $path = $this->saveimage ($request);
                $user=User::findorfail($id);
                $user->user_image=$path;
                $user->save();

                return response()->json([
                    'file is' => 'present',
                    'filename' => $path
                ]);

        }
        else{
            Storage::disk ('local')->append ('uploadimage.txt',"not file present" );
            return response()->json([
                'file is not' => 'present'
            ]);


        }
        }catch (Exception $exception) {

            Storage::disk ('local')->append ('useruploadimageerror',$exception );
        }

    }

    private function saveimage (Request $request)
    {
        try{
            if ($request->file ('upload-photo') != null) {

                $path = Storage::disk ('images')->putFile ('', $request->file ('upload-photo'));

                if (!is_dir ($this->photos_path)) {
                    mkdir ($this->photos_path, 0777);
                }
                $img = Image::make ('Images\\' . $path);
                $img->resize (150, 150);
                $img->save ('assets\images\profiles\\' . $path);
                $image_path = 'Images\\' . $path;  // Value is not URL but directory file path
                if (File::exists ($image_path)) {

                    File::delete ('Images\\' . $path);
                }

            return $path;
            }
            return '0';
        }
        catch (Exception $exception) {

            Storage::disk ('local')->append ('useruploadimageerror',$exception );
        }

    }


    public function addrole($id,$role){
        try {

            $user=User::findorfail($id);
            if($user){
                $user->roles()->attach(Role::where('name',$role )->first());
                return "done";

            }

        }catch (Exception $exception) {

            return $exception;
        }


    }


    public function removerole($id,$role){
        try {

            $user=User::findorfail($id);
            if($user){
                $user->roles()->detach(Role::where('name',$role )->first());
                if($user->roles()->count() ==0 ) {
                    $user->roles()->attach(Role::where('name','Learner' )->first());

                }
                return "done";

            }

        }catch (Exception $exception) {

            return $exception;
        }


    }

    public function invitefriend ($id){

        $user=User::findorfail($id) ;

        $invitedusers=Inviteduser::where('invitedby','=',$id)->get();
        if($user) return view ('users.invitefriend', compact ('user' ,'invitedusers'));
        else return view ('/home');

    }


    public function addchildren ($id){

        $user=User::findorfail($id) ;


        if($user)  {
            $children=User::where('parentmail','=',$user->email)->get();
            $grades = Grade::pluck('grade_name','id')->all();
            $schools = School::pluck('school_name','id')->all();

            return   view ('users.add-children', compact ('user' ,'grades' , 'schools','children'));
        }
        else return view ('/home');

    }

    public function savechild ( Request $request ,$id ){
      //  try{
        $sender=User::findorfail($id);
        $data = $this->getData($request);
        $data['parentmail']=$sender->email;
        $data['isapproved_byparent']=1;
        $data['isintroinfo_displayed']=0;
        $data['lastloggedon']='';
        $data['parent_id']=User::findorfail($id)->id;
        $token = base64_encode(random_bytes(64));
        $token =substr( strtr($token, '+/', '-_') ,0,60);
        $data['password']=Hash::make($data['password']);
        $data['remember_token']=$token;
        $child=  User::create($data);
        $child->roles ()->attach (Role::where ('name', 'Learner')->first ());

        event (new UserRegistered($child));
        $data= array();
        $data['sender'] = serialize($sender);

        $job = (new AddChildJob( $child ))->delay (Carbon::now ()->addSeconds (15));
        $this->dispatch ($job);
      //  Mail::to ($data['email'])-> send(new InviteChildMail (  'SDSDSD', $sender ,$child));

        return redirect()->route('users.user.childrenlist',$sender->id)
            ->with('success_message', 'User was successfully added!');
    /*  } catch (Exception $exception) {
    return back ()->withInput ()
        ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
    }  */
    }


    /**
     * Show the form for editing the specified user.
     ** param int $id
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $grades = Grade::pluck('grade_name','id')->all();
        $schools = School::pluck('school_name','id')->all();
        $parents = User::pluck('name','id')->all();
        $countries = Country::pluck('country_name','id')->all();
        $uilanguages = Language::pluck('language','id')->all();

        return view('users.edit', compact('user','providers','grades','schools','parents','countries','uilanguages'));
    }

    public  function childrenlist($id){
        $user=User::findorfail($id) ;

        if($user)  {
            $children=User::where('parentmail','=',$user->email)->get();
            return   view ('users.childrenlist', compact ('children'));
        }
        else return view ('/home');

    }

    /**
     * Update the specified user in the storage.
     ** param  int $id
     */
    public function update($id, Request $request)
    {
        try {
            $data  = $this->getData($request);
            $user = User::findOrFail($id);
            $user->update($data);

            return redirect()->route('users.user.index')
                             ->with('success_message', 'User is successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    public function updateprofile($id, Request $request)
    {
        try {

            $data  = $this->getprofileData($request);
            $user = User::findOrFail($id);
            $user->update($data);
            $profile=User::where('id','=',$id)->select('id','name' ,'mobile' ,'email' ,'gender', 'country_id', 'user_image' ,'grade_id','school_id' ,'uilanguage_id' ,'dob' ,'phone')->first();
            $profilepersent=$user->calculate_profile($profile);

            event(new CompleteProfile($profilepersent));
            return redirect()->route('users.user.profile' ,$id)
                ->with('success_message', 'User is successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified user from the storage.
     ** param  int $id
     ** return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('users.user.index')
                             ->with('success_message', 'User was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Get the request's data from the request.
     */
    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:250',
            'email' => 'required|string|email|max:255|unique:users',
            'provider' => 'nullable|string|min:0|max:500',
            'provider_id' => 'nullable',
            'mobile' => 'nullable|string|min:0|max:50',
            'gender' => 'nullable',
            'password' => 'required|string|min:6|confirmed',
            'user_image' => 'nullable|string|min:0|max:250',
            'isactive' => 'boolean',
            'lastloggedon' => 'nullable|date_format:j/n/Y g:i A',
            'registeredon' => 'nullable|date_format:j/n/Y g:i A',

            'isverified' => 'boolean',
            'role_type_id' => 'nullable',
            'grade_id' => 'nullable',
            'school_id' => 'nullable',
            'parent_id' => 'nullable',
            'country_id' => 'nullable|numeric|min:0|max:4294967295',
            'uilanguage_id' => 'nullable|numeric|min:0|max:4294967295',
            'dob' => 'nullable|date|date_format:Y-m-d',
            'phone' => 'nullable|string|min:0|max:50',
            'parentmail' => 'nullable|string|min:0|max:50',
            'isapproved_byparent' => 'boolean',
            'isintroinfo_displayed' => 'boolean',
            'passwordtoken' => 'nullable|string|min:0|max:100',
            'registeredby' => 'required',
            'totalpoints' => 'required|numeric|min:0|max:2147483647',
            'remember_token' => 'nullable|string|min:0|max:100',

        ];

        $data = $request->validate($rules);

        // boolean values are not in the request if checkbox is not checked that's why you need to add them to data
        $data['isactive'] = $request->has('isactive');
        $data['isverified'] = $request->has('isverified');
        $data['isapproved_byparent'] = $request->has('isapproved_byparent');
        $data['isintroinfo_displayed'] = $request->has('isintroinfo_displayed');

        return $data;
    }

    protected function getprofileData(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:250',
            'email' => 'required||string|min:1|max:25',
            'mobile' => 'nullable|string|min:0|max:50',
            'gender' => 'nullable',
            'registeredon' => 'nullable|date_format:j/n/Y g:i A',
            'country_id' => 'nullable|numeric|min:0|max:4294967295',
            'grade_id' => 'nullable|numeric|min:0|max:4294967295',
            'uilanguage_id' => 'nullable|numeric|min:0|max:4294967295',
            'dob' => 'nullable',
            'phone' => 'nullable|string|min:0|max:50',
            'parentmail' => 'nullable|string|min:0|max:50',
            'aboutme' => 'nullable',
        ];

        $data = $request->validate($rules);

        return $data;
    }

}
