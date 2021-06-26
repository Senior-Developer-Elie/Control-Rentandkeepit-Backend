<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Role;


class ApiAuthController extends Controller
{
    public function getCurrentUserInfo()
    {
        $user = Auth::user();
        $response = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->getRoleNames()[0],
            'avatar' => $user->image_path ?  $user->image_path : '',  
        ];

        return response($response);
    }

    public function login (Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        
        if ($user) 
        {
            if (Hash::check($request->password, $user->password))
            {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = [
                                'id' => $user->id,
                                'name' => $user->name,
                                'email' => $user->email,
                                'uuid' => $user->uuid,
                                'access_token' => $token,
                                'role' => 'Owner',
                                'avatar' => $user->image_path ?  $user->image_path : '',
                            ];
                //return response($response);
                return response($response, 200);
            } 
            else 
            {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } 
        else 
        {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function register (Request $request) 
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
 //       return response($user->instructor);
        $response = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'uuid' => $user->uuid,
            'access_token' => $token,            
            'role' => 'Owner',
        ];    
        return response($response, 200);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();

        if($user) {
            $password = Str::random(10);
            $user->password = bcrypt($password);
            if($user->save()) {
                $from = 'admin@gmail.com';
                $to = $user->email;
                $message = "Your password was successfully changed. Please check your email.";
                //$this->sendEmailToAdmin($from, $to, $message);

                return response([
                    'password' => $password,
                ]);
            }
        }

        return response([
            'password' => 'failed',
        ]);
    } 

    public function logout () 
    {
        //$token = $request->user()->token();
        $token = Auth::user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function sendEmailToAdmin($from, $to, $message) {
        $user = Auth::user();
        $data = array('message' => $message);
   
        Mail::send(['text'=>'mail'], $data, function($message) {
        
            $message->to($to, 'Tutorials Point')->subject('Laravel Basic Testing Mail');
            $message->from($from, 'Virat Gandhi');
        });
    }

}
