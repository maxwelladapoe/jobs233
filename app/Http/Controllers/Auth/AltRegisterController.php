<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AltRegisterController extends Controller
{

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('api');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:35', 'min:5', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6',],
            'preference' => ['required', 'string']
        ]);

        $preference = strtolower($request['preference']);
        $preferenceArray = ['work', 'hire'];
        if (in_array($preference, $preferenceArray)) {


            $user = User::create([
                'first_name' => ucfirst(strtolower(trim($request['firstName']))),
                'last_name' => ucfirst(strtolower(trim($request['lastName']))),
                'name' => ucfirst(strtolower(trim($request['firstName']))) . " " . ucfirst(strtolower(trim($request['lastName']))),
                'username' => strtolower(trim($request['username'])),
                'email' => strtolower(trim($request['email'])),
                'password' => Hash::make(trim($request['password'])),
            ]);

            $user->sendEmailVerificationNotification();
            if ($user) {

                $profile = Profile::create([
                    'user_id' => $user->id,
                    'preference' => strtolower($request['preference']),
                ]);

                if ($profile) {
                    event(new Registered($user));

                    return response()->json(['success' => true, 'message' => 'Your profile was created successfully',
                        'additionalMessage' => 'An Email verification link sent on your email id'
                    ], 200);
                }
            } else {
                Log::debug("there seems to be an issue with user creation. you may have to check the database");
                return response()->json(['success' => false, 'message' => 'oops something went wrong'], 500);
            }

        } else {
            return response()->json(['success' => false, 'message' => 'the preference selected does not exist'], 500);

        }


    }

    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6',],
        ]);
    }


    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => trim($data['email']),
            'password' => Hash::make(trim($data['password'])),
        ]);

        if ($user) {
            Profile::create([
                'user_id' => $user->id,
                'preference' => $data['preference'],
            ]);
        }

        return $user;
    }
}
