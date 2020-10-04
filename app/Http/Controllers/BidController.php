<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BidController extends Controller
{
    //


    public function create(Request $request)
    {
        $this->validate($request, [
            'project_id' => ['required', 'integer'],
            'currency' => ['required', 'integer'],
            'amount' => ['required', 'integer'],
            'additional_details' => ['nullable', 'string'],

        ]);


        $existingBid = Bid::where('user_id', Auth::user()->id)->where('project_id', $request['project_id'])->get();

        if (count($existingBid) == 0) {
            $bid = new Bid();
            $bid->project_id = $request['project_id'];
            $bid->user_id = Auth::user()->id;
            $bid->currency_id = $request['currency'];
            $bid->amount = $request['amount'];
            $bid->additional_details = $request['additional_details'];


            if ($bid->save()) {
                return response()->json(['success' => true, 'message' => 'Your bid has been placed successfully'], 201);
            } else {
                Log::debug("there seems to be an issue with project creation. you may have to check the database");
                return response()->json(['success' => false, 'message' => 'oops something went wrong'], 500);
            }

        } else {
            return response()->json(['success' => false, 'message' => 'You have already placed a bid for this project'], 401);
        }


    }

    public function read()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
