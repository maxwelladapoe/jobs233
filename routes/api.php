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


Route::prefix('v1')->group(function () {


    Route::middleware('auth:sanctum')->prefix('user')->group(function () {
        Route::get('/', function (Request $request) {
            return $request->user();
        });

        Route::get('/projects', [App\Http\Controllers\ProfileController::class, 'projects']);
    });

    Route::prefix('auth')->group(function () {
        Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
        Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
        Route::post('register', [App\Http\Controllers\Auth\AltRegisterController::class, 'register']);
    });
    Route::get('/currencies', [App\Http\Controllers\CurrencyController::class, 'read']);


    Route::prefix('projects')->group(function () {
        Route::post('/', [App\Http\Controllers\ProjectController::class, 'create']);
        Route::get('/', [App\Http\Controllers\ProjectController::class, 'getProjects']);
        Route::get('/categories', [App\Http\Controllers\ProjectController::class, 'getCategoriesAndSkills']);
        Route::get('/{project}', [App\Http\Controllers\ProjectController::class, 'read']);
        Route::patch('/update/{id}', [App\Http\Controllers\ProjectController::class, 'update']);
        Route::delete('/delete/{id}', [App\Http\Controllers\ProjectController::class, 'delete']);
    });


    Route::prefix('profile')->group(function () {
        Route::patch('/', [App\Http\Controllers\ProfileController::class, 'update']);
        Route::post('/picture', [App\Http\Controllers\ProfileController::class, 'changeProfilePicture']);
    });


});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
