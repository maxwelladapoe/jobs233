<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //

    protected $imageUploadPath;

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
            'username' => ['required', 'string', 'min:5', 'max:10', 'unique:users'],
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


        $user->name = ucwords(strtolower($request['name']));


        if ($profile->save() && $user->save()) {
            return response()->json(['success' => true, 'profile' => $profile], 200);
        } else {

            return response()->json(['success' => false, 'message' => 'the profile for this user does not seem to exist'], 400);
        }
    }


    public function projects()
    {
        $user = Auth::user();
        $projects = Project::where('user_id', $user->id)->get();

        return response()->json(['success' => true, 'projects' => $projects], 200);

    }

    public function changeProfilePicture(Request $request)
    {

        $this->validate($request, [
            'image' => ['required', 'image', 'max:2000']
        ]);

        $profile = Profile::find(Auth::user()->profile->id);


        if ($profile) {

            // Handle file Upload
            if ($request->hasFile('image')) {

                //Storage::delete('/public/avatars/'.$user->avatar);

                // Get filename with the extension
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = md5($filename) . '_' . time() . '.' . $extension;
                // Upload Image
                $path = $request->file('image')->storeAs('public/userimages', $fileNameToStore);

                $profile->picture = '/storage/userimages/' . $fileNameToStore;

                if ($profile->save()) {
                    return response()->json(['success' => true,
                        'message' => 'profile picture changed successfully',
                        'path' => '/storage/userimages/' . $fileNameToStore], 201);
                }

            }


        }


    }


}
