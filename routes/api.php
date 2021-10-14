<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\UserController;
use \App\Http\Controllers\Api\IntroController;
use \App\Http\Controllers\Api\JobController;
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

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::post('/intro',[IntroController::class,'show']);
Route::group(['middleware'=>'auth:api'],function (){
    Route::get('profile/{id?}',[UserController::class,'profile']);
    Route::post('search',[JobController::class,'search']);
    Route::post('jobs',[JobController::class,'show']);
    Route::post('job/add',[JobController::class,'add']);
    Route::put('profile/edit',[UserController::class,'edit']);
    Route::post('social/add',[UserController::class,'addSocial']);
    Route::post('experience/add',[UserController::class,'addExperience']);
    Route::post('education/add',[UserController::class,'addEducation']);
    Route::post('job/apply',[JobController::class,'applyJob']);
    Route::post('user/apply',[JobController::class,'userApply']);
    Route::post('edit/status',[JobController::class,'editStatus']);
    Route::get('verifcation_code',[UserController::class,'verifcation_code']);
    Route::post('/verify',[UserController::class,'verify']);

});
