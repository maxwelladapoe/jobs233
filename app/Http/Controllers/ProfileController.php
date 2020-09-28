<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');

    }


    public function read()
    {

        $profile = Profile::where('user_id', Auth::user()->id);

        if ($profile) {
            return response()->json(['success' => true, 'profile' => $profile], 200);
        } else {

            return response()->json(['success' => false, 'message' => 'the profile for this user does not seem to exist'], 400);
        }
    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email'],
            'phone_number' => ['nullable', 'integer'],
            'gender' => ['required'],
            'bio' => ['nullable', 'min:3'],
            'country' => ['nullable', 'string', 'min:3'],
            'city' => ['nullable', 'string', 'min:2'],
            'address' => ['nullable', 'string'],
        ]);

        $user = User::find(Auth::user()->id);

        $profile = Profile::find($user->profile->id);

        $profile->phone_number = $request['phone_number'];
        $profile->gender = $request['gender'];
        $profile->bio = $request['bio'];
        $profile->address = $request['address'];
        $profile->country = $request['country'];
        $profile->city = $request['city'];


        $user->name= $request['name'];

        if ($profile->save() ) {
            return response()->json(['success' => true, 'profile' => $profile], 200);
        } else {

            return response()->json(['success' => false, 'message' => 'the profile for this user does not seem to exist'], 400);
        }
    }


}
