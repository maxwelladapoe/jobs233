<?php

namespace App\Http\Controllers;

use App\Models\PaymentOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    //

    public function getPaymentOptions(){
        if (Auth::user()){

            $paymentOptions = PaymentOption:: all();

            return response()->json(['success'=>true, 'payment_options'=> $paymentOptions]);
        }
    }
}
