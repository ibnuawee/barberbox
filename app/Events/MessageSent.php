<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $message;
    public function __construct(Message $message)
    {
        //
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // Log::info('Broadcasting to channe: chat' . $this->message->receiver_id);
        // return new Channel('chat.' . $this->message->receiver_id);
        return new Channel('messages');
    }

    // public function broadcastWith()
    // {
    //     return ['message' => $this->message];
    // }
}
