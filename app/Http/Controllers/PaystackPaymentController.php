<?php

namespace App\Http\Controllers;

use App\Models\InterfaceLogger;
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


    public function handleGatewayCallback()
    {


        try {


            $paymentDetails = Paystack::getPaymentData();


            $user = Auth::user();
            $paymentDetailsData = $paymentDetails['data'];
            $customerDetails = $paymentDetailsData['customer'];
            $transactionAmount = $paymentDetailsData['amount'];
            $authorizationData = $paymentDetailsData['authorization'];
            $metaData = $customerDetails['metadata'];


            $interfaceLogger = InterfaceLogger::where('reference', $paymentDetailsData['reference'])->get();


            if (count($interfaceLogger) < 1) {
                $interfaceLogger = new InterfaceLogger();
                $interfaceLogger->user_id = $user->id;
                $interfaceLogger->authorization_code = $authorizationData['authorization_code'];
                $interfaceLogger->reference = $paymentDetailsData['reference'];
                $interfaceLogger->platform = 'paystack';
                $interfaceLogger->ip = $paymentDetailsData['ip_address'];

                $interfaceLogger->currency = $paymentDetailsData['currency'];
                $interfaceLogger->amount = $paymentDetailsData['amount'];
                $interfaceLogger->channel = $paymentDetailsData['channel'];
                $interfaceLogger->status = $paymentDetailsData['status'];
                $interfaceLogger->response = json_encode($paymentDetails);
                $interfaceLogger->save();
                $user->deposit($transactionAmount);

                return response()->json(['success' => true,
                    'message' => 'deposit made successfully',
                    'amount' => [
                        'currency' => $paymentDetailsData['currency'],
                        'amount' => $paymentDetailsData['amount']
                    ]
                ], 200);

            } else {
                return response()->json(['success' => true,
                    'message' => 'confirmed earlier successfully deposit',
                    'amount' => [
                        'currency' => $paymentDetailsData['currency'],
                        'amount' => $paymentDetailsData['amount']
                    ]], 200);
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
