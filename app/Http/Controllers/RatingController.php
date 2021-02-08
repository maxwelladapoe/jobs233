<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function create(Request $request)
    {

        //qow: Quality of work

        $this->validate($request, [
            'projectId' => ['required'],
            'qow' => ['required', 'between:0,5.0'],
            'skill' => ['required', 'between:0,5.0'],
            'communication' => ['required', 'between:0,5.0'],
            'timeliness' => ['required', 'between:0,5.0'],
            'review' => ['required', 'string'],
            'hireAgain' => ['required', 'string'],
            'totalAverageRating' => ['required', 'between:0,5.0'],
        ]);


        $project = Project::find($request['projectId']);

        if ($project) {

            if (Auth::user()->id === $project->user_id) {

                $ratingExists = Rating::where('project_id',$request['projectId'])->where('user_id',
                    $project->worker->id)->first();

                if ($ratingExists){
                    $project->worker_already_rated=true;
                    $project->save();
                    return response()->json(['success' => true, 'message' => 'you have already rated this user for this project'],
                        200);
                }

                $rating = new Rating();
                $rating->rated_by_user_id = Auth::user()->id;
                $rating->project_id = $project->id;
                $rating->user_id = $project->worker->id;
                $rating->total_average_rating = $request['totalAverageRating'];
                $rating->hire_again = $request['hireAgain'];
                $rating->review = trim($request['review']);
                $rating->timeliness = $request['timeliness'];
                $rating->communication = $request['communication'];
                $rating->cooperation = $request['cooperation'];
                $rating->skill = $request['skill'];
                $rating->qow = $request['qow'];


                if ($rating->save()) {
                    $averageUserRating= Rating::where('user_id', $project->worker->id)->average('total_average_rating');
                    $project->worker->profile->rating=$averageUserRating;
                    $project->worker->profile->save();
                    $project->worker_already_rated=true;
                    $project->save();

                    return response()->json(
                        ['success' => true,
                            'message' => 'Thanks for the feedback'], 200);
                }



            } else {
                return response()->json(['success' => false, 'message' => 'this project does not belong to you'], 401);

            }

        } else {
            return response()->json(['success' => false, 'message' => 'this project does not exist'], 400);
        }


    }
}
