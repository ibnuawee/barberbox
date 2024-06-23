<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function index($receiverId)
    {
        return view('chat.index', ['receiverId' => $receiverId]);
    }
}
