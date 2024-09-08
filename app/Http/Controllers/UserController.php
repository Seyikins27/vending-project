<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Seyi\AirtimeVend\Airtime;
use Seyi\AirtimeVend\Models\NetworkProvider;
use Seyi\AirtimeVend\Models\VendingPartner;

class UserController extends Controller
{
    public function register(Request $request)
    {
       try{
        $data=$request->validate([
            'name'=>'required',
            'email'=>'email|required|unique:users,email',
            'password'=>'required|confirmed|min:8|string',
        ]);

        $user_data=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        
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
            'message'=>'Error registering user',
            'errors'=>$errors
          ]);
       }
    }

    public function purchase_airtime(Request $request)
    {
       try{
         $request->validate([
            'network_provider'=>'required|exists:network_providers,id',
            'vending_partner'=>'required|exists:vending_partners,id',
            'data'=>'array',
            'data.amount'=>'required|numeric',
            'data.phone'=>'required'
         ]);
         $network_provider=NetworkProvider::findOrFail($request->network_provider);
         $vending_partner=VendingPartner::findOrFail($request->vending_partner);
         $header_parameters=[];
         $request_parameters=[];
         $network_attribute=[$vending_partner->network_attribute=>$network_provider->code_name];

         foreach($vending_partner->header_information as $header_information)
         {
            $header_parameters[$header_information]=isset($request->data[$header_information])?$request->data[$header_information]:null;
         }

         foreach($vending_partner->parameters as $request_parameter)
         {
            $request_parameters[$request_parameter]=isset($request->data[$request_parameter])?$request->data[$request_parameter]:null;
         }

         $data=[
            'request_params'=>array_merge($request_parameters, $network_attribute),
            'header_params'=>$header_parameters
         ];

         $vend=Airtime::vend($network_provider, $vending_partner, $data);
         
         if($vend['status']==true)
         {
            return response()->json([
                'status'=>true,
                'message'=>'Airtime purchased successfully',
                'data'=>$vend['data']['data']
            ]);
         }
         else
         {
            //i am intentionally displaying the exception errors the exception errors ideally will be logged
            throw new Exception($vend['message']." : ".$vend['error']);
         }
       }
       catch(Exception $e)
       {
        return response()->json([
            'status'=>false,
            'message'=>'Error vending airtime',
            'errors'=>$e->getMessage()
          ]);
       }
    }
    
}
