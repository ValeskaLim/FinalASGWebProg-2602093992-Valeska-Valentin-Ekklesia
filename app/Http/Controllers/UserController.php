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
            return redirect()->route('user.show', $id)->with('error', __('messages.error_friendself'));
        }

        if ($loggedInUser->sentFriendRequests()->where('receiver_id', $id)->exists()) {
            return redirect()->route('user.show', $id)->with('error', __('messages.friend_request_message'));
        }

        if ($loggedInUser->receivedFriendRequests()->where('sender_id', $id)->exists()) {
            return redirect()->route('user.show', $id)->with('error', __('messages.pending_request_message'));
        }

        $loggedInUser->sentFriendRequests()->create([
            'receiver_id' => $id,
        ]);

        return redirect()->route('user.show', $id)->with('success', __('messages.friend_request_sent_success', ['username' => $userToAdd->username]));
    }

    public function acceptFriendRequest($id)
    {
        $loggedInUser = Auth::user();
        $friendRequest = $loggedInUser->receivedFriendRequests()->where('sender_id', $id)->firstOrFail();

        $loggedInUser->friends()->attach($friendRequest->sender_id);
        $friendRequest->sender->friends()->attach($loggedInUser->id);

        $friendRequest->delete();

        return redirect()->route('home')->with('success', __('messages.already_friend_message', ['username' => $friendRequest->sender->username]));
    }

    public function rejectFriendRequest($id)
    {
        $loggedInUser = Auth::user();
        $friendRequest = $loggedInUser->receivedFriendRequests()->where('sender_id', $id)->firstOrFail();

        $friendRequest->delete();

        return redirect()->route('home')->with('success', __('messages.reject_friend_message', ['username' => $friendRequest->sender->username]));
    }


    public function removeFriend($id)
    {
        $loggedInUser = Auth::user();
        $userToRemove = User::findOrFail($id);

        if ($loggedInUser && $loggedInUser->friends()->where('friend_id', $id)->exists()) {
            $loggedInUser->friends()->detach($userToRemove);
            $userToRemove->friends()->detach($loggedInUser);
            return redirect()->route('user.show', $id)->with('success', __('messages.remove_friend_message', ['username' => $userToRemove->username]));
        }

        return redirect()->route('user.show', $id)->with('error', __('messages.not_friend_message', ['username' => $userToRemove->username]));
    }
}
