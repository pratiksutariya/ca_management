<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\{User};


class PermissionController extends Controller
{
    public function assignPermission(Request $request) {
        try {
            $users = User::find($request->user_id);
            $users->givePermissionTo($request->permission);  
            return response()->json(['status' => false, 'message' => "Assign Permission" ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage() ], 500);
        }

    } 

    public function revokePermission(Request $request) {
        try {
            $users = User::find($request->user_id);
            $users->revokePermissionTo($request->permission);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "Revoke Permission" ], 500);
        }

    } 
}
