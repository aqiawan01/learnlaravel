<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use File;

class HomeController extends Controller
{
     public function profile()
    {
    	return view('admin/home/profile');
    }

    public function profile_update(Request $request)
    {
    	$user = Auth::user();
        
        $this->validate(request(), [
        	'name' => 'required',
        	'designation' => 'required',
        	'bio' => 'required',
        ]);

        $fileName = $user->user_img;
        if (request()->hasFile('user_img')) 
        {
        	$file = request()->file('user_img');
        	$fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getclientOriginalExtension();
        	$file->move('./uploads/', $fileName);

        	File::delete('./uploads/', $user->user_img);
        }


        $data = $request->all();
        $data['user_img'] = $fileName;
        $user->update($data);
        return redirect()->back();
    }


    public function updatepassword(Request $request)
    {
        $this->validate(request(), [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ], [
            'current_password.required' => 'Current password shouldnt be empty!',
            'new_password.required' => 'New password likhna shouldnt be empty!',
            'new_confirm_password.required|same:new_password' => 'The confirm password field is must be match with new password',
        ]);


        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_confirm_password)]);

        return  redirect()->back(); 
    }
}
