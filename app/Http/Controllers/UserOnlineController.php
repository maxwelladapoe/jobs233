<?php

namespace App\Http\Controllers;

use App\Events\UserOffline;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\UserOnline;
use Illuminate\Support\Facades\Auth;


class UserOnlineController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');

    }


    public function setOnlineStatus(User $user)
    {
        $user->is_online = true;
        $user->save();

        broadcast(new UserOnline($user));
    }


    public function setOfflineStatus(User $user)
    {

        $user->is_online = false;
        $user->save();

        broadcast(new UserOffline($user));
    }
}
