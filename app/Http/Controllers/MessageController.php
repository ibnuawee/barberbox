<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    //
    public function index($receiver_id)
    {
        return view('chat.index', ['receiver_id' => $receiver_id]);
    }

    public function getMessages($receiver_id)
    {
        $user_id = Auth::id();

        // Ambil pesan antara user yang login dan receiver
        $messages = Message::where(function($query) use ($user_id, $receiver_id) {
            $query->where('sender_id', $user_id)
                ->where('receiver_id', $receiver_id);
        })->orWhere(function($query) use ($user_id, $receiver_id) {
            $query->where('sender_id', $receiver_id)
                ->where('receiver_id', $user_id);
        })->orderBy('created_at', 'asc')->get();

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

        // Log::info('Pesan terkirim', ['message' => $message]);

        broadcast(new MessageSent($message))->toOthers();

        // Log::info('Pesan dibroadcast', ['message' => $message]);

        return response()->json(['message' => $message]);
    }

}
