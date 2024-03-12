<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
        AuthController,
        PermissionController,
        SuperAdmin\UserController
    };

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::group(['prefix' => 'user','middleware' => ['auth:api']], function () { 
    Route::get('/logout', [AuthController::class, 'logout']);
});
Route::group(['prefix' => 'ca','middleware' => ['auth:api','role:super-admin']], function () {
    Route::post('/add-new-ca', [UserController::class, 'new_ca_account']);
    
});

