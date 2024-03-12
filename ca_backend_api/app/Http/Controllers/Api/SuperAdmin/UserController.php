<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use App\Models\{User};
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

class UserController extends Controller
{
    public function new_ca_account(Request $reuest) {
        try {
            $rules = [
                'email' => 'required|unique:users', 
                'password' => 'required', 
                'name' => 'required',
            ];
            $validator = Validator::make($request->all() , $rules, 
                        $messages = [
                            'email.required' => 'Username or Email is required',
                            'email.unique' => 'Username or Email is already Use',
                            'password.required' => 'Password is required',
                            'name.required' => 'Name is required'
                        ]
                    );
            if ($validator->fails())
            {
                return response()
                    ->json(['status' => false, 'message' => $validator->errors() ], 403);
            }
        } catch(\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage() ], 500);
        }
    }
}
