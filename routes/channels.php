<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});


//
//Broadcast::channel('lchat', function ($user) {
//    return auth()->check();
//});

Broadcast::channel('jobs233_messaging.{receiverid}', function ($user, $receiverid) {

    return auth()->check();
});

Broadcast::channel('jobs233-project-{project_id}', function ($project_id) {
    return auth()->check();
});


Broadcast::channel('jobs233-projects-new-post', function ($project) {
    return auth()->check();
});

Broadcast::channel('jobs233_ymiutkyihzrihztnzwar', function ($user) {

    if (auth()->check()) {
        //check if the user is part of the contact before returning
        if (Auth::user()->allChatContacts()->where('user_id', $user->id)->count() > 0
            || Auth::user()->allChatContacts()->where('related_user_id', $user->id)->count()>0) {
            return $user;
        }

    }

});
