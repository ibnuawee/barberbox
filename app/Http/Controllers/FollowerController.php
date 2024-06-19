<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follower;
use App\Models\User;
use App\Models\Barber;

class FollowerController extends Controller
{
    public function follow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'barber_id' => 'required|exists:barbers,id',
        ]);

        Follower::create([
            'user_id' => $request->user_id,
            'barber_id' => $request->barber_id,
        ]);

        return response()->json(['message' => 'Followed successfully'], 200);
    }

    public function unfollow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'barber_id' => 'required|exists:barbers,id',
        ]);

        Follower::where('user_id', $request->user_id)
            ->where('barber_id', $request->barber_id)
            ->delete();

        return response()->json(['message' => 'Unfollowed successfully'], 200);
    }

    public function followers($barber_id)
    {
        $followers = Barber::find($barber_id)->users;
        return response()->json($followers, 200);
    }

    public function following($user_id)
    {
        $following = User::find($user_id)->barbers;
        return response()->json($following, 200);
    }
}