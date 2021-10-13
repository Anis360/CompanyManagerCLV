<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Validator;

use App\Http\Requests;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        if (Auth::User())
        {
            return view('auth.changepassword');
        }
        else
        {
            return redirect()->guest('login');
        }
    }
    public function changePassword(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Votre mot de passe actuel n'est pas égal au mot de passe que vous avez entré. Veuillez réessayer.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","Le nouveau mot de passe doit être différent du mot de passe actuel. Veuillez choisir un mot de passe différent.");
        }

        $this->validate($request, [
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->password_changed_at = \Carbon\Carbon::now();
        $user->save();

        return redirect()->back()->with("success","Votre mot de passe a été changé avec succès !");

    }
}
