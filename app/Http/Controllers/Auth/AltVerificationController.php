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
        $this->middleware('auth');

    }

    public function verify($user_id, Request $request)
    {


        if (!$request->hasValidSignature()) {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }

        if (Auth::user() && Auth::user()->id == $user_id) {
            $user = User::findOrFail($user_id);

            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
                return redirect()->to('/email-verified');
            }else{
                return redirect()->to('/email-already-verified');
            }


        } else {
            return redirect()->to('/forbidden');
        }

    }

    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 400);
        }

        auth()->user()->sendEmailVerificationNotification();

        return response()->json(["message" => "Email verification link sent on your email id"]);
    }
}
