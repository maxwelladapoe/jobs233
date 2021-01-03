<?php

namespace App\Http\Controllers;

use App\Models\PaymentOption;
use App\Models\ProjectPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    //


    public function __construct()
    {
        $this->middleware('auth');

    }


    public function getPaymentOptions(){
        if (Auth::user()){

            $paymentOptions = PaymentOption:: all();

            return response()->json(['success'=>true, 'payment_options'=> $paymentOptions]);
        }
    }


    public function getAllDeposits(){
        $deposits = ProjectPayment::where('user_id', Auth::user()->id)->latest()->paginate(30);
        return response()->json(['success' => true, 'deposits' => $deposits], 200);
    }
}
