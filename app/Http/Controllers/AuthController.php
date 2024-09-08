<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
       $request->validate([
         'email'=>'required|email|string|',
         'password'=>'required'
       ]);
    
      $user=User::where('email',$request->email)->first();
      
      if(Hash::check($request->password,$user->password))
      {
      $token=$user->createToken('user-'.$user->name)->plainTextToken;
      auth()->login($user);
      return response()->json([
          'status'=>true,
          'message'=>'User Logged in successfully',
          'token'=>$token
        ]);
      }
      else
      {
        return response()->json([
          'status'=>false,
          'message'=>'Wrong Username and password combination'
        ]);
      }
      
    }

}
