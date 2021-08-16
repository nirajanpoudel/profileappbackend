<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');

header("Access-Control-Allow-Headers: *");



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
        // Route::get('profiles', [ProfileController::class, 'listProfiles']);

});
Route::group(['middleware' => ['cors']], function() {
    Route::post('auth', [AuthController::class, 'auth']);
   
});



Route::group(['middleware' => ['cors','jwt']], function() {
    Route::post('profile', [ProfileController::class, 'uploadProfile']);
    Route::get('profiles', [ProfileController::class, 'listProfiles']);
   
});