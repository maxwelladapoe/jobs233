<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//Auth::routes();

//Route::get('email/verify', [App\Http\Controllers\Auth\VerificationController::class ,'show'])->name('verification.notice');
//Route::get('email/verify/{id}', [App\Http\Controllers\Auth\VerificationController::class,'verify'])->name('verification.verify');
//Route::get('email/resend', [App\Http\Controllers\Auth\VerificationController::class,'resend'])->name('verification
//.resend');




Route::get('email/verify/{id}', [App\Http\Controllers\Auth\AltVerificationController::class, 'verify'])->name('verification.verify');


//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('password/reset/{token}', [ App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name
('password.reset');

Route::post('password/reset',[App\Http\Controllers\Auth\ResetPasswordController::class,'reset'])->name('password.update');

Route::get('/payment/callback', [App\Http\Controllers\PaystackPaymentController::class, 'handleGatewayCallback']);



Route::get('back_end_service/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->where('any', '.*');
Route::get('back_end_service/{any}', [App\Http\Controllers\Admin\AdminController::class, 'index'])->where('any', '.*');

Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any', '.*');
