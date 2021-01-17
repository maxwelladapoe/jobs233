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

        Route::get('/projects', [App\Http\Controllers\ProfileController::class, 'getUserProjects']);

        Route::get('/pp/get-transaction-reference', [App\Http\Controllers\PaystackPaymentController::class, 'getTransferRef']);

    });


    Route::get('email/verify/{id}', [App\Http\Controllers\Auth\AltVerificationController::class, 'verify'])->name('verification.verify');
    Route::get('email/resend', [App\Http\Controllers\Auth\AltVerificationController::class, 'resend'])->name('verification.resend');


    Route::prefix('auth')->group(function () {
        Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
        Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
        Route::post('register', [App\Http\Controllers\Auth\AltRegisterController::class, 'register'])->name('register');
        Route::put('{user}/is_online', [App\Http\Controllers\UserOnlineController::class, 'setOnlineStatus'])->name('onlineStatus');
        Route::put('{user}/is_offline', [App\Http\Controllers\UserOnlineController::class, 'setOfflineStatus'])->name
        ('offlineStatus');
    });

    Route::get('/currencies', [App\Http\Controllers\CurrencyController::class, 'read']);
    Route::get('/notifications', [App\Http\Controllers\ProfileController::class, 'getNotifications']);
    Route::post('/notifications/mark_all_as_read', [App\Http\Controllers\ProfileController::class, 'markAllAsRead']);


    Route::prefix('projects')->group(function () {
        Route::post('/', [App\Http\Controllers\ProjectController::class, 'create']);
        Route::get('/', [App\Http\Controllers\ProjectController::class, 'index']);
        Route::get('/assigned', [App\Http\Controllers\AssignedProjectController::class, 'index']);
        Route::post('/search', [App\Http\Controllers\ProjectController::class, 'search']);
        Route::post('/mark_as_completed', [App\Http\Controllers\ProjectController::class, 'markProjectAsCompleted']);
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


    //payment paystack

    Route::get('/payment_options', [App\Http\Controllers\PaymentsController::class, 'getPaymentOptions']);


    Route::post('/pay/{project}', [App\Http\Controllers\PaystackPaymentController::class, 'redirectToGatewayForDeposit']);
    Route::get('/payment/callback', [App\Http\Controllers\PaystackPaymentController::class, 'handleGatewayCallback']);

    //deposits
    Route::get('/deposits', [App\Http\Controllers\PaymentsController::class, 'getAllDeposits']);


    //skills
    Route::get('/skills', [App\Http\Controllers\ProjectController::class, 'getSkills']);

    Route::get('/portfolio', [App\Http\Controllers\PortfolioItemController::class, 'getAll']);


    Route::post('/portfolio/add', [App\Http\Controllers\PortfolioItemController::class, 'create']);

    Route::delete('/portfolio/delete/{portfolioItem}', [App\Http\Controllers\PortfolioItemController::class, 'delete']);


    //forgot password
    Route::post('password-reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail']);


    //getting he profile
    Route::get('{username}', [App\Http\Controllers\ProfileController::class, 'readProfileForPublic']);

});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
