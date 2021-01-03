<?php

namespace App\Http\Controllers;

use App\Models\ProjectPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectPaymentController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');

    }


}
