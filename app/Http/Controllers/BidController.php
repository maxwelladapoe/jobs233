<?php

namespace App\Http\Controllers;

use App\Mail\BidAcceptedMailToEmployer;
use App\Mail\BidAcceptedMailToWorker;
use App\Mail\BidPlacedSuccessfullyMailToWorker;
use App\Mail\BidPlacedSuccessfullyMailToEmployer;
use App\Models\Bid;
use App\Models\ChatContact;
use App\Models\Project;
use App\Models\ProjectPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BidController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function create(Request $request)
    {
        $this->validate($request, [
            //'project_id' => ['required', 'integer'],
            'currency' => ['required', 'integer'],
            'amount' => ['required', 'integer'],
            'additional_details' => ['nullable', 'string'],

        ]);


        $existingBid = Bid::where('user_id', Auth::user()->id)->where('project_id', $request['project_id'])->first();



        if (!$existingBid) {
            $bid = new Bid();
            $bid->project_id = $request['project_id'];
            $bid->user_id = Auth::user()->id;
            $bid->currency_id = $request['currency'];
            $bid->amount = doubleval($request['amount']);
            $bid->additional_details = $request['additional_details'];


            if ($bid->save()) {


                $project = $bid->project;
                $projectCreator = $project->user;


                //send email to the employer and the worker
                Mail::to($bid->user->email)->queue(new BidPlacedSuccessfullyMailToWorker($bid));

                Mail::to($projectCreator->email)->queue(new BidPlacedSuccessfullyMailToEmployer($bid));

                return response()->json(['success' => true, 'message' => 'Your bid has been placed successfully', 'bid' => $bid], 201);
            } else {
                Log::debug("there seems to be an issue with project creation. you may have to check the database");
                return response()->json(['success' => false, 'message' => 'oops something went wrong'], 500);
            }

        } else {


            if ($existingBid->is_accepted === 0) {
                $existingBid->project_id = $request['project_id'];
                $existingBid->user_id = Auth::user()->id;
                $existingBid->currency_id = $request['currency'];
                $existingBid->amount = doubleval($request['amount']);
                $existingBid->additional_details = $request['additional_details'];

                if ($existingBid->save()) {
                    return response()->json(['success' => true, 'message' => 'Your bid has been updated successfully', 'bid' => $existingBid], 201);

                } else {
                    Log::debug("there seems to be an issue with updating the bid you may have to check the database");
                    return response()->json(['success' => false, 'message' => 'oops something went wrong'], 500);

                }


            } else {
                return response()->json(['success' => false, 'message' => 'Your bid has already been accepted'], 401);

            }

        }


    }

    public function acceptBid(Request $request)
    {
        $this->validate($request, [
            'bid_id' => ['required', 'integer'],
            'project_id' => ['required'],
        ]);

        //check if the bid id exists
        $bid = Bid::find($request['bid_id']);
        //check if the project id exists
        $project = $bid->project;
        //check the initiator of the project and ensure it is the authorised user

        if (!$project->bidding_closed || $project->accepted_bid_id == null) {
            if ($project->user_id === Auth::user()->id) {
                //we can allow the user to modify the project and accept the bid
                $bid->is_accepted = true;
                $project->accepted_bid_id = $bid->id;
                $project->bidding_closed = true;
                $project->worker_id = $bid->user_id;
                $project->status = 'assigned';

                $contactEmployer = new ChatContact();
                $contactWorker  = new ChatContact();

                $contactEmployer->user_id = Auth::user()->id;
                $contactEmployer->related_user_id = $bid->user_id;
                $contactEmployer->chat_enabled =true;
                $contactEmployer->save();

                $contactWorker->user_id = $bid->user_id ;
                $contactWorker->related_user_id = Auth::user()->id;
                $contactWorker->chat_enabled =true;

                $contactWorker->save();


                //recalculate Balance

                //check if a deposit has been made
                //if there are no deposits
                $projectPayment = ProjectPayment::where('project_id', $project->id);

                if ($projectPayment->count() > 0){
                    //reduce the minn payable amount to 1

                    $oldAmountPaid = (doubleval($project->budget) - doubleval
                        ($project->balance)) ;
                    $newBalance = doubleval($bid->amount) - $oldAmountPaid ;


                }else{
                    //the minimum payable amount is half of the final agreed offer

                    $newBalance = doubleval($bid->amount);

                }


                $project->balance = $newBalance;






                if ($project->save() && $bid->save()) {
                    //notify the user of the accepted bid

                    Mail::to($bid->user->email)->queue(new BidAcceptedMailToWorker($bid));


                    Mail::to(Auth::user()->email)->queue(new BidAcceptedMailToEmployer($bid));

                    return response()->json(['success' => true,
                        'message' => 'You have accepted the bid with id: ' . $bid->id . ' successfully',
                        'bid' => $bid, 'project' => $project], 201);
                } else {

                }

            } else {
                return response()->json(['success' => false, 'message' => 'You are not authorised to accept this bid'], 401);

            }
        } else {
            return response()->json(['success' => false, 'message' => 'Bidding has been closed'], 401);

        }


        //check the initiator of the project and ensure it is the authorised user


    }

    public function read()
    {

    }

    public function update(Request $request)
    {


        $this->validate($request, [
            //'project_id' => ['required', 'integer'],
            'currency' => ['required', 'integer'],
            'amount' => ['required', 'integer'],
            'additional_details' => ['nullable', 'string'],

        ]);

        $existingBid = Bid::where('user_id', Auth::user()->id)->where('project_id', $request['project_id']);

        if ($existingBid->is_accepted === '0') {
            $existingBid->user_id = Auth::user()->id;
            $existingBid->currency_id = $request['currency'];
            $existingBid->amount = doubleval($request['amount']);
            $existingBid->additional_details = $request['additional_details'];

            if ($existingBid->save()) {
                return response()->json(['success' => true, 'message' => 'Your bid has been updated successfully', 'bid' => $existingBid], 201);

            } else {


            }


        }
    }

    public function delete()
    {

    }
}
