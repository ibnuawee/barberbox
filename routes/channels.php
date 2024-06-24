<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('chat.{receiver_id}', function ($user, $receiver_id) {
    Log::info('Authorizing user for chat channel', ['user_id' => $user->id, 'receiver_id' => $receiver_id]);
    return (int) $user->id === (int) $receiver_id;
});

// Broadcast::channel('message', function ($user, $receiver_id) {
//     Log::info('Authorizing user for chat channel', ['user_id' => $user->id, 'receiver_id' => $receiver_id]);
//     return (int) $user->id === (int) $receiver_id;
// });
