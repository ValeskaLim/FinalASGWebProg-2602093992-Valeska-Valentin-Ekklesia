<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $loggedInUser = Auth::user();
        $isFriend = $loggedInUser ? $loggedInUser->friends()->where('friend_id', $id)->exists() : false;

        $user->profile_picture = 'https://ui-avatars.com/api/?name=' . urlencode($user->username) . '&background=random';

        return view('pages.user.show', compact('loggedInUser', 'user', 'isFriend'));
    }

    public function addFriend($id)
    {
        $loggedInUser = Auth::user();
        $userToAdd = User::findOrFail($id);

        if ($loggedInUser->id === $id) {
            return redirect()->route('user.show', $id)->with('error', "You cannot send a friend request to yourself.");
        }

        if ($loggedInUser->sentFriendRequests()->where('receiver_id', $id)->exists()) {
            return redirect()->route('user.show', $id)->with('error', "Friend request already sent.");
        }

        if ($loggedInUser->receivedFriendRequests()->where('sender_id', $id)->exists()) {
            return redirect()->route('user.show', $id)->with('error', "You already have a pending friend request from this user.");
        }

        $loggedInUser->sentFriendRequests()->create([
            'receiver_id' => $id,
        ]);

        return redirect()->route('user.show', $id)->with('success', "Friend request sent to {$userToAdd->username}.");
    }

    public function acceptFriendRequest($id)
    {
        $loggedInUser = Auth::user();
        $friendRequest = $loggedInUser->receivedFriendRequests()->where('sender_id', $id)->firstOrFail();

        $loggedInUser->friends()->attach($friendRequest->sender_id);
        $friendRequest->sender->friends()->attach($loggedInUser->id);

        $friendRequest->delete();

        return redirect()->route('home')->with('success', "You are now friends with {$friendRequest->sender->username}.");
    }

    public function rejectFriendRequest($id)
    {
        $loggedInUser = Auth::user();
        $friendRequest = $loggedInUser->receivedFriendRequests()->where('sender_id', $id)->firstOrFail();

        $friendRequest->delete();

        return redirect()->route('home')->with('success', "Friend request from {$friendRequest->sender->username} rejected.");
    }


    public function removeFriend($id)
    {
        $loggedInUser = Auth::user();
        $userToRemove = User::findOrFail($id);

        if ($loggedInUser && $loggedInUser->friends()->where('friend_id', $id)->exists()) {
            $loggedInUser->friends()->detach($userToRemove);
            $userToRemove->friends()->detach($loggedInUser);
            return redirect()->route('user.show', $id)->with('success', "{$userToRemove->username} removed from your friends.");
        }

        return redirect()->route('user.show', $id)->with('error', "{$userToRemove->username} is not your friend.");
    }
}
