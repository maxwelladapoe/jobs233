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

        Route::get('/pp/get-transaction-reference', [App\Http\Controllers\PaystackPaymentController::class, 'getTransferRef']);

    });

    Route::prefix('auth')->group(function () {
        Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
        Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
        Route::post('register', [App\Http\Controllers\Auth\AltRegisterController::class, 'register']);
        Route::put('{user}/is_online', [App\Http\Controllers\UserOnlineController::class, 'setOnlineStatus']);
        Route::put('{user}/is_offline', [App\Http\Controllers\UserOnlineController::class, 'setOfflineStatus']);
    });

    Route::get('/currencies', [App\Http\Controllers\CurrencyController::class, 'read']);
    Route::get('/notifications', [App\Http\Controllers\ProfileController::class, 'getNotifications']);
    Route::post('/notifications/mark_all_as_read', [App\Http\Controllers\ProfileController::class, 'markAllAsRead']);


    Route::prefix('projects')->group(function () {
        Route::post('/', [App\Http\Controllers\ProjectController::class, 'create']);
        Route::get('/', [App\Http\Controllers\ProjectController::class, 'getProjects']);
        Route::get('/assigned', [App\Http\Controllers\ProjectController::class, 'getAssignedProjects']);
        Route::post('/search', [App\Http\Controllers\ProjectController::class, 'search']);
        Route::get('/categories-skills', [App\Http\Controllers\ProjectController::class, 'getCategoriesAndSkills']);
        Route::get('/categories', [App\Http\Controllers\ProjectController::class, 'getCategories']);
        Route::get('/skills', [App\Http\Controllers\ProjectController::class, 'getSkills']);
        Route::get('/assigned/{project}', [App\Http\Controllers\ProjectController::class, 'getAssignedProject']);
        Route::get('/{project}', [App\Http\Controllers\ProjectController::class, 'read']);
        Route::patch('/update/{id}', [App\Http\Controllers\ProjectController::class, 'update']);
        Route::post('/update-status', [App\Http\Controllers\ProjectController::class, 'updateStatus']);
        Route::get('/status-updates/{project}', [App\Http\Controllers\ProjectController::class, 'statusUpdates']);
        Route::delete('/delete/{id}', [App\Http\Controllers\ProjectController::class, 'delete']);

        //bid
        Route::prefix('{project_id}')->group(function () {
            Route::post('/accept_bid', [App\Http\Controllers\BidController::class, 'acceptBid']);
            Route::get('/', [App\Http\Controllers\BidController::class, 'getBids']);


            Route::prefix('bids')->group(function () {
                Route::post('/', [App\Http\Controllers\BidController::class, 'create']);
                Route::get('/', [App\Http\Controllers\BidController::class, 'getBids']);
            });
        });


    });


    Route::prefix('profile')->group(function () {
        Route::patch('/', [App\Http\Controllers\ProfileController::class, 'update']);
        Route::post('/picture', [App\Http\Controllers\ProfileController::class, 'changeProfilePicture']);
    });

    Route::prefix('messages')->group(function () {
        Route::post('/', [App\Http\Controllers\MessageController::class, 'create']);
        Route::get('{user}/getAll', [App\Http\Controllers\MessageController::class, 'read']);
        Route::get('/contacts', [App\Http\Controllers\ChatContactController::class, 'getAllContacts']);
    });


    Route::prefix('{user}')->group(function () {
        Route::get('/portfolio', [App\Http\Controllers\PortfolioItemController::class, 'create']);
    });

    Route::post('/portfolio/add', [App\Http\Controllers\PortfolioItemController::class, 'create']);


    //payment paystack

    Route::post('/pay', [App\Http\Controllers\PaystackPaymentController::class, 'redirectToGateway']);
    Route::get('/payment/callback', [App\Http\Controllers\PaystackPaymentController::class, 'handleGatewayCallback']);


    //skills
    Route::get('/skills', [App\Http\Controllers\ProjectController::class, 'getSkills']);

    //getting he profile
    Route::get('{username}', [App\Http\Controllers\ProfileController::class, 'readProfileForPublic']);



    //forgot password
    Route::post('password-reset',[App\Http\Controllers\Auth\ForgotPasswordController::class,'sendResetLinkEmail']);

});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
