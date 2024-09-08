<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
       try{
        $data=$request->validate([
            'name'=>'required',
            'phone'=>'required',
            'email'=>'email|required'
        ]);

        $user_data=User::create($data);
        
        return response()->json([
            'status'=>true,
            'message'=>'User Registered successfully',
            'data'=>$user_data
        ]);
       }
       catch(ValidationException $e)
       {
        $errors = collect($e->errors())->flatten()->unique()->toArray();
          return response()->json([
            'status'=>false,
            'message'=>'Error regsitering user',
            'errors'=>$errors
          ]);
       }
    }

    
}
