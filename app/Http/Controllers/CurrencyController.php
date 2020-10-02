<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    //

    public function read()
    {
        $currencies = Currency::all();
        return response()->json(['success'=>true, 'currencies'=> $currencies]);
    }
}
