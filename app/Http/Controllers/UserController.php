<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

  public function login()
    {
        return view('login');
    }

    public function login_user(Request $request)
    {
      $validated_data = $request->validate(
        [
          'email'=>'required',
          'password'=>'required'
        ]
        );
        if(Auth::attempt($validated_data)){
          return redirect()->route('homepage');
        }else{
          return redirect()->back()->with('message','INVALID LOGIN');
        }

    }

    public function registration_form()
    {
        return view('registration');
    }

     public function store_user(Request $request)
    {
      $validated_data = $request->validate([
        'name'=>'required',
        'email'=> 'required',
        'password'=>'required',
      ]);
      $validated_data ['password']=Hash::make($request->password);
      User::create($validated_data);
      return redirect()->back()->with('message','Account created');


    }
       public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
