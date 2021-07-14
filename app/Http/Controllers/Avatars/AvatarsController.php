<?php

namespace App\Http\Controllers\Avatars;

use App\Models\Avatar;
use App\Models\User;
use App\Models\AvatarAccessorie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;


class AvatarsController extends Controller
{
    //getAvatarForAdmin, avatarCreate, avatarStore, avataredit, avatarupdate, avatarDestroy
    //getAccessoriesForAdmin, avatarAccessoriesCreate, avatarAccessoriesStore, avatarAccessoriesEdit, avatarAccessoriesUpdate, avatarAccessoriesDestroy
    //getAccessories, updateAvatar,
    //Data Validation: getAvatarData, getAvatarAccessoriesData

    public function __construct()
    {

    }

    /**
     * Admin get avatars
     */
    public function getAvatarForAdmin(){

      $avatars = Avatar::paginate(25);
      return view('avatars.avatar',compact('avatars'));
    }

    /**
     * Admin create avatar.
     */
    public function avatarCreate(){
      return view('avatars.avatar-create');
    }

    /**
     * Admin store avatar.
     */
    public function avatarStore(Request $request){

      $data = $this->getAvatarData($request,'create');

      $image = $request->file('image');
      $name = $image->getClientOriginalName();
      $destinationPath = public_path('/assets/eduplaycloud/image/');
      $image->move($destinationPath, $name);

      $data['image'] = $name;

      Avatar::create($data);
      return redirect()->route('avatars.admin.avatar')
            ->with('success_message', 'Avatar was successfully added!');
    }
    
    /**
     * Admin edit avatar.
     */
    public function avataredit($id){
      $avatar =  Avatar::findOrFail($id);
      return view('avatars.avatar-edit')->with(['avatar' => $avatar]);
    }

    /**
     * Admin update avatar.
     */
    public function avatarupdate(Request $request,$id){

      $data = $this->getAvatarData($request,'update');
      if(isset($request->image)){
        $image = $request->file('image');
        $name = $image->getClientOriginalName();
        $destinationPath = public_path('/assets/eduplaycloud/image/');
        $image->move($destinationPath, $name);
        $data['image'] = $name;
      }

      $avatar =  Avatar::findOrFail($id);
      $avatar->update($data);

      return redirect()->route('avatars.admin.avatar')
              ->with('success_message', 'Avatar was successfully updated!');
    }

    /**
     * Admin Remove avatar.
     */
    public function avatarDestroy($id){
      $avatar = Avatar::findOrFail($id);
      $filename = public_path('/assets/eduplaycloud/image/'.$avatar->image);

      if (file_exists($filename)) {
        unlink($filename);
      }

      //remove related accessories
      if(count($avatar->accessories) > 0){
        foreach($avatar->accessories as $accessories){

          $filename = public_path('/assets/eduplaycloud/image/'.$accessories->image);

          if (file_exists($filename)) {
            unlink($filename);
          }
          $accessories->delete();
        }
      }
      $avatar->delete();
      return redirect()->route('avatars.admin.avatar')
            ->with('success_message', 'Avatar was successfully deleted!');
    }
    
    /**
     * Admin get avatar accessories
     */
    public function getAccessoriesForAdmin(){
      $avatarAccessories = AvatarAccessorie::with('avatar')->paginate(25);
      return view('avatars.avatar-accessories',compact('avatarAccessories'));
    }

    /**
     * Admin create avatar accessories.
     */
    public function avatarAccessoriesCreate(){
      $avatars = Avatar::select('name','id')->get();
      return view('avatars.accessories-create',compact('avatars'));
    }

    /**
     * Admin store avatar accessories .
     */
    public function avatarAccessoriesStore(Request $request){
      $data = $this->getAvatarAccessoriesData($request,'create');
      $image = $request->file('image');
      $name = $image->getClientOriginalName();
      $destinationPath = public_path('/assets/eduplaycloud/image/');
      $image->move($destinationPath, $name);

      $data['image'] = $name;

      AvatarAccessorie::create($data);

      return redirect()->route('avatars.avatar.accessories')
            ->with('success_message', 'Accessories was successfully added!');

    }

    /**
     * Admin edit avatar accessories.
     */
    public function avatarAccessoriesEdit($id){
      $avatars = Avatar::select('name','id')->get();
      $accessories =  AvatarAccessorie::findOrFail($id);

      return view('avatars.accessories-edit',compact('avatars','accessories'));

    }

    /**
     * Admin update avatar accessories.
     */
    public function avatarAccessoriesUpdate(Request $request,$id){

      $data = $this->getAvatarAccessoriesData($request,'update');

      if(isset($request->image)){
        $image = $request->file('image');
        $name = $image->getClientOriginalName();
        $destinationPath = public_path('/assets/eduplaycloud/image/');
        $image->move($destinationPath, $name);
  
        $data['image'] = $name;
      }

      $avatarAccessorie =  AvatarAccessorie::findOrFail($id);
      $avatarAccessorie->update($data);

      return redirect()->route('avatars.avatar.accessories')
            ->with('success_message', 'Accessories was successfully updated!');
    }

    /**
     * Admin destroy avatar accessories .
     */
    public function avatarAccessoriesDestroy($id){
      $accessories = AvatarAccessorie::findOrFail($id);
      $filename = public_path('/assets/eduplaycloud/image/'.$accessories->image);

      if (file_exists($filename)) {
        unlink($filename);
      }

      $accessories->delete();
      return redirect()->route('avatars.avatar.accessories')
            ->with('success_message', 'Accessories was successfully deleted!');
    }


    /**
     * get avatar accessories -Developed By : WC
     */
    public function getAccessories($id) {
        $accessories = AvatarAccessorie::with('avatar')
                            ->where('avatar_id',$id)
                            ->select('id','avatar_id','image','points')
                            ->get();

        $user = User::select('id','totalpoints')
                    ->find(Auth::user()->id);

        // Get User total points
        $userTotalPoints = $user->totalpoints;
        return view('eduplaycloud.users.avatar-accessories',compact('accessories','userTotalPoints'));
    }

    /**
     * update avatars -Developed By : WC
     */
    public function updateAvatar(Request $request) {
        $avatarAccess = AvatarAccessorie::select('id','image')->findorFail($request->avatar_acc_id);
        $imagePath = "/assets/eduplaycloud/image";
        $newPath = "/assets/images/profiles/";
        $imagePath = public_path($imagePath).'/'.$avatarAccess->image;
        $newPath = public_path($newPath);
        if (file_exists($imagePath)) {
            $extention = explode('.',$avatarAccess->image);
            $ext = '.'.$extention[1];
            $image = time().$ext;
            $newName  = $newPath.$image;
            $copied = copy($imagePath , $newName);
            if ((!$copied)) {
                return redirect()->route('users.user.profile',Auth::user()->id.'#pills-avtar')
                                ->with('error_message', Lang::get('profile.unable_avatar_update'));
            } else { 
                // Update user profile
                $user = User::select('id','user_image')->findorFail(Auth::user()->id);
                // Delete old user image from folder
                if ($user->user_image != "" && file_exists(public_path('assets/images/profiles/'.$user->user_image))) {
                    unlink(public_path('assets/images/profiles/'.$user->user_image));
                }
                $user->user_image = $image;
                $user->save();
                return redirect()->route('users.user.profile',Auth::user()->id.'#pills-avtar')
                        ->with('success_message', Lang::get('profile.avatar_updated'));
            }    
        } else {
            return redirect()->route('users.user.profile',Auth::user()->id.'#pills-avtar')
                                ->with('error_message', Lang::get('profile.unable_avatar_update'));
        }
    }

    /**
     * Avatar validation.
     */
    protected function getAvatarData(Request $request,$mode)
    {
        $rules = [
            'name' => 'required|string|min:1|max:250',
            'category' => 'required|string|min:1|max:100',
            'points' => 'nullable|numeric|min:1|max:9999999999',
        ];

        if($mode === 'create'){
          $rules['image'] = 'required';
        }

        $data = $request->validate($rules);
        return $data;
    }

    /**
    * Avatar accessories validation.
    */
    protected function getAvatarAccessoriesData(Request $request, $mode)
    {
        $rules = [
            'avatar_id' => 'required',
            'points' => 'nullable|numeric|min:1|max:9999999999',
        ];

        if($mode == 'create') {
          $rules['image'] = 'required';
        }

        $data = $request->validate($rules);
        return $data;
    }

}