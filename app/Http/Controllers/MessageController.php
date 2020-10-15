<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //


    public function __construct()
    {
        $this->middleware('auth');

    }


    public function create(Request $request)
    {

        $this->validate($request, [
            'message' => ['required', 'string'],
            'receiver_id' => ['required', 'integer'],
        ]);
        //check if the receiver exists

        $message = Auth::user()->messages()->create([
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
            ]
        );




        if ($message) {
            broadcast(new MessageSent($message->load('user')))->toOthers();


            return response()->json(['success' => true, 'message' => $message], 200);
        } else {
            return response()->json(['success' => false], 500);
        }
    }


    public function read(User $user)
    {
        $messages = Message::with('user')
            ->where(['user_id' => Auth::user()->id, 'receiver_id' => $user->id])
            ->orWhere(function ($query) use ($user) {
                $query->where(['user_id' => $user->id, 'receiver_id' => Auth::user()->id]);
            })->latest()
            ->paginate(20);

        return response()->json(['success' => true, 'messages' => $messages], 200);
    }
}
