<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AltVerificationController extends Controller
{
//

    public function __construct()
    {
        // $this->middleware('auth');

    }

    public function verify($user_id, Request $request)
    {


        if (!$request->hasValidSignature()) {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }


        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            return redirect()->to('/email-verified');
        } else {

            return redirect()->to('/email-already-verified');
        }


        // return redirect()->to('/forbidden');


    }

    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 400);
        }

        auth()->user()->sendEmailVerificationNotification();

        return response()->json(["message" => "Email verification link sent on your email id"]);
    }


    public function resendAfterSignup(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email']);

        $user = User::where('email', $request['email'])->first();

        if (!$user) {
            return response()->json(["success" => false, "message" => "User does not exist"], 400);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(["success" => true, "message" => "Email already verified."], 200);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(["success" => true,"message" => "Email verification link sent on your email id"], 200);
    }
}
