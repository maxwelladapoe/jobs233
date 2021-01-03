<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\InterfaceLogger;
use App\Models\Project;
use App\Models\ProjectPayment;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;
use Unicodeveloper\Paystack\TransRef;


class PaystackPaymentController extends Controller
{


    public function redirectToGateway()
    {
        try {

            return response()->json(['success' => true,
                'redirect_route' => Paystack::getAuthorizationUrl()], 200);


        } catch (\Exception $e) {
            return response()->json(['success' => false,
                'error' => $e->getMessage()], 400);

        }


    }

    public function redirectToGatewayForDeposit(Project $project, Request $request)
    {



        $this->validate($request, [
            "amount" => 'required',
            "email" => 'required|email',
            "orderId" => 'required|string',
            "currency" => 'required',
            "reference" => 'required|string',
            "metadata" => 'required',
            "id" => 'required'

        ]);

        if ($project->user_id == Auth::user()->id) {

            //if the project has an accepted bid use that

            $amountInput = doubleval(str_replace(',','',$request['inputAmount']));


            $acceptedBid = Bid::find($project->accepted_bid_id);
            if ($acceptedBid){
                $finalAgreedOfferAmount = doubleval(str_replace(',', '', $acceptedBid->amount));

            }else{
                $finalAgreedOfferAmount = doubleval(str_replace(',','',$project->budget));
            }


            //if there are no deposits
            $projectPayment = ProjectPayment::where('project_id', $project->id);

            if ($projectPayment->count() > 0){
                //reduce the minn payable amount to 1
                $minPayableAmount =1;
                $maxPayableAmount =doubleval($project->balance);
            }else{
                //the minimum payable amount is half of the final agreed offer
                $minPayableAmount = $finalAgreedOfferAmount * 0.5;
                $maxPayableAmount = $finalAgreedOfferAmount;
            }



            if ($amountInput >= $minPayableAmount){

                if ($amountInput <= $maxPayableAmount ){
                    try {

                        return response()->json(['success' => true,
                            'redirect_route' => Paystack::getAuthorizationUrl()], 200);


                    } catch (\Exception $e) {
                        return response()->json(['success' => false,
                            'error' => $e->getMessage()], 400);

                    }
                }else{
                    return response()->json(['success' => false,
                        'message' => "amount is more than the expected ". $maxPayableAmount], 400);
                }

            }else{
                return response()->json(['success' => false,
                    'message' => "amount is less than the expected ". $minPayableAmount], 400);
            }



        } else {
            return response()->json(['success' => false,
                'message' => "this project does not belong to this authorised user"], 401);
        }


    }


    public function handleGatewayCallback()
    {


        try {


            $paymentDetails = Paystack::getPaymentData();


            $user = Auth::user();
            $paymentDetailsData = $paymentDetails['data'];
            $customerDetails = $paymentDetailsData['customer'];
            $transactionAmount = doubleval($paymentDetailsData['amount']) / 100;
            $authorizationData = $paymentDetailsData['authorization'];
            $metaData = $paymentDetailsData['metadata'];


            $interfaceLogger = InterfaceLogger::where('reference', $paymentDetailsData['reference'])->get();

            if ($interfaceLogger->count() < 1) {
                $interfaceLogger = new InterfaceLogger();
                $interfaceLogger->user_id = $user->id;
                $interfaceLogger->authorization_code = $authorizationData["authorization_code"];
                $interfaceLogger->reference = $paymentDetailsData["reference"];
                $interfaceLogger->platform = 'paystack';
                $interfaceLogger->ip = $paymentDetailsData["ip_address"];

                $interfaceLogger->currency = $paymentDetailsData["currency"];
                $interfaceLogger->amount = $transactionAmount;
                $interfaceLogger->channel = $paymentDetailsData["channel"];
                $interfaceLogger->status = $paymentDetailsData["status"];
                $interfaceLogger->response = json_encode($paymentDetails);
                $interfaceLogger->save();
                $user->deposit($transactionAmount);

                $projectPayment = new ProjectPayment;
                $projectPayment->project_id = $metaData["project_id"];
                $projectPayment->user_id = Auth::user()->id;
                $projectPayment->payment_id = $paymentDetailsData["id"];
                $projectPayment->amount = $transactionAmount;

                if($projectPayment->save()){

                    $project = Project::find($metaData["project_id"]);
                    if ($project){
                        $project->deposit_made = true;
                        $project->balance = doubleval($project->balance) - $transactionAmount;
                        $project->save();

                        return response()->json(['success' => true,
                            'message' => 'deposit made successfully',
                            "paymentDetails" =>[
                                "projectId"=>$metaData["project_id"],
                                "paymentId"=>$paymentDetailsData["id"],
                                "currency" => $paymentDetailsData["currency"],
                                "amount" => $paymentDetailsData["amount"]
                            ]
                        ], 200);
                    }
                }





            } else {

                return response()->json(['success' => true,
                    'message' => 'confirmed earlier successfully deposit',
                    "paymentDetails" =>[
                        "projectId"=>$metaData["project_id"],
                        "paymentId"=>$paymentDetailsData["id"],
                        "currency" => $paymentDetailsData["currency"],
                        "amount" => $paymentDetailsData["amount"]
                    ],
                  ], 200);

            }


        } catch (\Exception $e) {

            Log::error($e);
            return response()->json(['success' => false,
                'error' => $e->getMessage()], 400);
        }
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }

    public function getTransferRef()
    {
        $paystackRef = TransRef::getHashedToken();
        return $paystackRef;
    }
}
