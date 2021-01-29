<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserSkills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    //

    protected $imageUploadPath;

    public function __construct()
    {
        $this->middleware('auth')->except('readProfileForPublic');

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


    public function readProfileForPublic(Request $request)
    {
        $user = User::where('username', $request['username'])->with('portfolio')->get();

        if ($user) {
            return response()->json(['success' => true, 'user' => $user], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'the profile for this user does not seem to exist'], 400);

        }
    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'first_name' => ['required', 'string', 'min:3'],
            'last_name' => ['required', 'string', 'min:3'],
            'title' => ['nullable', 'string', 'min:3'],
            'phone_number' => ['nullable', 'string', 'min:10', 'max:15'],
            'gender' => ['nullable'],
            'bio' => ['nullable', 'min:3'],
            'country' => ['nullable', 'string', 'min:3'],
            'city' => ['nullable', 'string', 'min:2'],
            'address' => ['nullable', 'string'],
        ]);

        $user = User::find(Auth::user()->id);

        $profile = $user->profile;

        $profile->title = $request['title'];
        $profile->phone_number = $request['phone_number'];
        $profile->gender = $request['gender'];
        $profile->bio = $request['bio'];
        $profile->address = $request['address'];
        $profile->country = $request['country'];
        $profile->city = $request['city'];


        $user->first_name = ucfirst(strtolower(trim($request['first_name'])));
        $user->last_name = ucfirst(strtolower(trim($request['last_name'])));

        $user->name = ucfirst(strtolower(trim($request['first_name']))) . " " . ucfirst(strtolower(trim($request['last_name'])));


        if ($profile->save() && $user->save()) {
            return response()->json(['success' => true, 'profile' => $profile, 'message' => 'Your profile has been updated successfully'], 200);
        } else {

            return response()->json(['success' => false, 'message' => 'the profile for this user does not seem to exist'], 400);
        }
    }


    public function getUserProjects(Request $request)
    {

        $projects = Project::where('user_id', Auth::user()->id)->latest()
            ->paginate($request->has('paginate') ? intval($request->paginate) : 0);


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

                $finalExtension = 'webp';
                $fileNameToStore = md5($filename) . '_' . time() . '.' . $finalExtension;
                // Upload Image

                $image = Image::make($request->file('image'));


                $resizeImage = $image->fit(400, 400, function ($constraint) {
                    $constraint->upsize();
                })->encode($finalExtension);

                //delete the old profile picture

                if ($profile->picture != '/storage/userimages/profile.svg') {
                    $fda = explode('/', $profile->picture);
                    $fd = end($fda);
                    Storage::delete('public/userimages/' . $fd);

                }

                $store = Storage::put('public/userimages/' . $fileNameToStore, $resizeImage);


                $profile->picture = '/storage/userimages/' . $fileNameToStore;

                if ($profile->save()) {
                    return response()->json(['success' => true,
                        'message' => 'profile picture changed successfully',
                        'path' => '/storage/userimages/' . $fileNameToStore], 201);
                }

            }


        }


    }


    public function getNotifications(Request $request)
    {

        if ($request->has('category')) {

            if ($request['category'] == 'unread') {
                $notifications = Auth::user()->unreadNotifications;

            } elseif ($request['category'] == 'read') {
                $notifications = Auth::user()->readNotifications;
            }
        } else {
            $notifications = Auth::user()->notifications;
        }
        return response()->json(['success' => true, 'notifications' => $notifications], 200);
    }

    public function markAllAsRead()
    {

        Auth::user()->notifications()->delete();
        return response()->json(['success' => true], 200);

    }


    public function addSkill(Request $request)
    {

        $this->validate($request, [
            'skill' => ['required', 'string', 'min:3']
        ]);


        $userSkills = Auth::user()->skills->pluck('skills')[0];

        $strArray = explode(',', strtolower($userSkills));


        if (in_array(strtolower($request['skill']), $strArray)) {

            return response()->json(['success' => false,
                'message' => $request['skill'] . ' has already been added'], 200);
        }

        if ($userSkills) {
            $userSkills = $userSkills . ',' . $request['skill'];
        } else {
            $userSkills = $request['skill'];
        }


        $skill = UserSkills::updateOrCreate(
            ['user_id' => Auth::user()->id],
            ['skills' => $userSkills]
        );

        return response()->json(['success' => true, 'message' => $request['skill'] . ' has been added successfully',
            'skills' => $skill], 200);

    }

    public function removeSkill(Request $request)
    {

        $this->validate($request, [
            'skill' => ['required', 'string', 'min:3']
        ]);

        $userSkills = Auth::user()->skills->pluck('skills')[0];

        $strArray = explode(',', $userSkills);


        if (in_array($request['skill'], $strArray)) {
            $key = array_search($request['skill'], $strArray);

            unset($strArray[$key]);

            $userSkills = trim(implode(',', $strArray));


            $skill = UserSkills::updateOrCreate(
                ['user_id' => Auth::user()->id],
                ['skills' => $userSkills]
            );

            return response()->json(['success' => true, 'message' => $request['skill'] . ' has been deleted successfully',
                'skills' => $skill], 200);

        } else {
            return response()->json(['success' => false,
                'message' => $request['skill'] . ' does not exist in your list'], 400);
        }


    }

}
