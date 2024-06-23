<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $messages = Message::where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $message = new Message([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        $message->save();

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message]);
    }

}
