<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;

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

    // tak tambah
    public function followBarber(Request $request)
    {
        $follower = new Follower([
            'user_id' => auth()->id(),
            'barber_id' => $request->barber_id,
        ]);
        $follower->save();

        // Increment followers count
        $barber = Barber::find($request->barber_id);
        $barber->increment('followers_count');

        return back()->with('success', 'You are now following this barber.');
    }

    public function unfollowBarber($barberId)
    {
        Follower::where('user_id', auth()->id())
            ->where('barber_id', $barberId)
            ->delete();

        // Decrement followers count
        $barber = Barber::find($barberId);
        $barber->decrement('followers_count');

        return back()->with('success', 'You have unfollowed this barber.');
    }

}
