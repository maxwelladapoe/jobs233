<?php

namespace App\Http\Controllers;

use App\Mail\ProjectCreatedSuccessfully;
use App\Mail\SubmitRequestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function submitRequest(Request $request){
        $this->validate($request,[
            'userType'=>['required','string'],
            'subject'=>['required','string'],
            'description'=>['required','string'],
            'email'=>['required','email'],
        ]);

        $requestDetails =[
            'user_type'=> $request['userType'],
            'subject'=> $request['subject'],
            'description'=> $request['description'],
            'email'=> $request['email'],
        ];

        Mail::to('support@jobs233.com')->queue(new SubmitRequestEmail($requestDetails));
        return response()->json(['success'=>true, 'message'=>'Your request has been submitted successfully', 'extraMessage'=>'We usually respond within 2 hours after submission']);

    }


}
