<?php

namespace App\Http\Controllers\GamePackAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function profile(Request $request)
    {
        $emailOrName = $request->input('emailOrName');
        $password = $request->input('password');


        $user = User::where('email' , $emailOrName)
        ->orWhere('name' , $emailOrName)
        ->first();


        if ( $user != null )
        {
            if ( Hash::check($password, $user->password) )
                return $this->renderProfileResponse(true , $user);
            else 
                return $this->renderProfileResponse(false);
        }
        else { 
            return $this->renderProfileResponse(false);
        }
    }

    public function validate_profile(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        
        $user = User::where('email' , $email)
        ->where('password' , $password)
        ->first();

        if ( $user != null )
        {
            return $this->renderProfileResponse(true , $user);
        }
        else { 
            return $this->renderProfileResponse(false);
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->dob = $request->input('dateOfBirth');
        
        return $this->renderProfileResponse(($user != null && $user->save() ) , $user);
    }

    public function renderProfileResponse($succeed, $user = null)
    {
        $profile = null;
        if ( $user != null )
            $profile = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'dateOfBirth' => $user->dob
            ];

        return json_encode([
            'succeed' => $succeed,
            'profile' => $profile,
        ]);
    }

    
}
