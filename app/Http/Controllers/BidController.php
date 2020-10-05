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
            //'project_id' => ['required', 'integer'],
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
            $bid->amount =number_format( $request['amount'],2);
            $bid->additional_details = $request['additional_details'];


            if ($bid->save()) {
                return response()->json(['success' => true, 'message' => 'Your bid has been placed successfully', 'bid' => $bid], 201);
            } else {
                Log::debug("there seems to be an issue with project creation. you may have to check the database");
                return response()->json(['success' => false, 'message' => 'oops something went wrong'], 500);
            }

        } else {
            if($existingBid->is_accepted==='0'){
                $existingBid->project_id = $request['project_id'];
                $existingBid->user_id = Auth::user()->id;
                $existingBid->currency_id = $request['currency'];
                $existingBid->amount =number_format( $request['amount'],2);
                $existingBid->additional_details = $request['additional_details'];

                if ($existingBid->save()){
                    return response()->json(['success' => true, 'message' => 'Your bid has been updated successfully', 'bid' => $existingBid], 201);

                }else{


                }


            }else{
                return response()->json(['success' => false, 'message' => 'Your bid has already been accepted'], 401);

            }


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
