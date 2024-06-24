<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function index($receiver_id)
    {
        return view('chat.index', ['receiver_id' => $receiver_id]);
    }
}
