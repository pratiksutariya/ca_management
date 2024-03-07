<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use App\Models\{User};
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        try {
            $rules = [
                        'email' => 'required|unique:users', 
                        'password' => 'required|required_with:confirm_password|same:confirm_password', 
                        'name' => 'required',
                        'confirm_password' => 'required'
                    ];
            $validator = Validator::make($request->all() , $rules, 
                        $messages = [
                            'email.required' => 'Username or Email is required',
                            'email.unique' => 'Username or Email is already Use',
                            'password.required' => 'Password is required',
                            'confirm_password.required' => 'Confirm Password is required',
                            'name.required' => 'Name is required'
                        ]
                    );
            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false, 'message' => $validator->errors() ], 403);
            }
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password),
                "visible_password" => $request->password
            ]);
            $role = Role::where('name' , 'user')->first();
            $user->assignRole($role);
            return response()->json(['status' => true, 'data' =>$user,'message'=>'SuccessFully Created New User'], 200);

        } catch(\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage() ], 500);
        }

    }

    public function login(Request $request) {
        try {
            $rules = ['email' => 'required', 'password' => 'required'];
            $validator = Validator::make($request->all() , $rules, 
                        $messages = [
                            'email.required' => 'Username or Email is required',
                            'password.required' => 'Password is required'
                        ]
                    );
            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false, 'message' => $validator->errors() ], 403);
            }
            if (!auth()->attempt(array('email' => $request->email,'password' => $request->password)))
            {
                return response()->json(['status' => false, 'message' => 'Invalid Credentials'], 400);
            }
            $accessToken = auth()->user()
                ->createToken('authToken')->accessToken;
            $user = auth()->user();
            $user_data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'access_token' => $accessToken,
                'role' => $user->getRoleNames()->first(),
            ];
            return response()->json(['status' => true, 'data' => $user_data, 'message' => "Login Successfully"], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage() ], 500);
        }
    }

    public function logout(){
        try
            {
                $auth_user = Auth::user()->token();
                $auth_user->revoke();
                return response()->json(['status' => true, 'message' => "Logout Successfully"], 200);
            }
        catch(\Exception $e)
        {
            return response()->json(['status' => false, 'message' => $e->getMessage() ], 500);
        }
    }

    public function update_profile(Request $request){
        try
            {
                $rules = [  
                    'email' => 'required|unique:users,email,'.$request->user_id, 
                    'name' => 'required',
                 ];
                $validator = Validator::make($request->all() , $rules, 
                            $messages = [
                                'email.required' => 'Username or Email is required',
                                'email.unique' => 'Username or Email is already Use',
                                'name.required' => 'Name is required'
                            ]
                        );
                if ($validator->fails())
                {
                    return response()
                    ->json(['status' => false, 'message' => $validator->errors() ], 403);
                }
                $user = User::find($request->user_id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->save();
                return response()->json(['status' => true, 'message' => "Logout Successfully" , "data" => $user], 200);
            }
        catch(\Exception $e)
        {
            return response()->json(['status' => false, 'message' => $e->getMessage() ], 500);
        }
    }

    public function update_password(Request $request){
        try
            {
                $rules = [  
                    'old_password' => 'required', 
                    'new_password' => 'required|required_with:confirm_password|same:confirm_password', 
                    'confirm_password' => 'required' 
                 ];
                $validator = Validator::make($request->all() , $rules, 
                            $messages = [
                                'old_password.required' => 'Old Password is required',
                                'new_password.required' => 'New Password is required',
                                'confirm_password.required' => 'Confirm Password is required',
                            ]
                        );
                if ($validator->fails())
                {
                    return response()
                    ->json(['status' => false, 'message' => $validator->errors() ], 403);
                }
                $user = User::where(array('id' => Auth::id() , 'visible_password' => $request->old_password))->first();
                if(!$user) {
                    return response()->json(['status' => false, 'message' => "Old Password does not match" , "data" => $user], 200);
                } 
                $user->visible_password = $request->new_password;
                $user->password = bcrypt($request->new_password);
                $user->save();
                return response()->json(['status' => true, 'message' => "Password Changed Succesfully" , "data" => $user], 200);
            }
        catch(\Exception $e)
        {
            return response()->json(['status' => false, 'message' => $e->getMessage() ], 500);
        }
    }
}
