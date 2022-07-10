<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class PusherController extends Controller
{
    public function pusher() {
        $user = Auth::user();
        if($user) {
            $pusher = new Pusher(
            '5a0433c31f35bd16d9d9',
            '9603761744491d2447ca',
            '1413679'
            );
            echo $pusher->socket_auth(request()->input('channel_name'), request()->input('socket_id'));
        } else {
            header('', true, 403);
            echo "Forbidden";
            return;
        }
    }
}
