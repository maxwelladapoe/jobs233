<?php

namespace App\Http\Controllers;

use App\Models\ChatContact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllContacts()
    {


        $relatedContactsIDS = ChatContact::where('related_user_id', Auth::user()->id)->pluck('user_id')->toArray();

        $allContacts = User::whereIn('id',$relatedContactsIDS)->orderBy('updated_at','desc')->get();

        return response()->json(['success' => true, 'contacts' => $allContacts], 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ChatContact $chatContact
     * @return \Illuminate\Http\Response
     */
    public function show(ChatContact $chatContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ChatContact $chatContact
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatContact $chatContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ChatContact $chatContact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatContact $chatContact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ChatContact $chatContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatContact $chatContact)
    {
        //
    }
}
