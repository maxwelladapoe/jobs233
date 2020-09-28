<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('auth')->group(function () {
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
    Route::post('register', [App\Http\Controllers\Auth\AltRegisterController::class, 'register']);


    //projects
});

Route::get('projects', [App\Http\Controllers\ProjectController::class, 'getProjects']);

Route::prefix('project')->group(function () {
    Route::post('/create', [App\Http\Controllers\ProjectController::class, 'create']);
    Route::get('/{id}/{slug}', [App\Http\Controllers\ProjectController::class, 'read']);
    Route::post('/update/{id}', [App\Http\Controllers\ProjectController::class, 'update']);
    Route::post('/delete/{id}', [App\Http\Controllers\ProjectController::class, 'delete']);
    Route::get('/categories', [App\Http\Controllers\ProjectController::class, 'getCategoriesAndSkills']);
});

Route::prefix('profile')->group(function () {
    Route::post('/update', [App\Http\Controllers\ProfileController::class, 'update']);
});


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
