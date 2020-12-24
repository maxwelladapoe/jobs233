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


//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('password/reset/{token}', [ App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name
('password.reset');

Route::post('password/reset',[App\Http\Controllers\Auth\ResetPasswordController::class,'reset'])->name('password.update');

Route::get('/payment/callback', [App\Http\Controllers\PaystackPaymentController::class, 'handleGatewayCallback']);

Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any', '.*');
