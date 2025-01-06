<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $loggedInUser = Auth::user();

        $friends = $loggedInUser->friends->map(function ($friend) use ($loggedInUser) {
            $friend->unread_count = Message::where('sender_id', $friend->id)
                                           ->where('receiver_id', $loggedInUser->id)
                                           ->where('is_read', false)
                                           ->count();

            $friend->profile_picture = 'https://ui-avatars.com/api/?name=' . urlencode($friend->username) . '&background=random';

            return $friend;
        });

        return view('pages.chat.index', compact('friends'));
    }

    public function fetchMessages($friendId)
    {
        $loggedInUser = Auth::user();

        $messages = Message::where(function ($query) use ($loggedInUser, $friendId) {
            $query->where('sender_id', $loggedInUser->id)
                  ->where('receiver_id', $friendId);
        })->orWhere(function ($query) use ($loggedInUser, $friendId) {
            $query->where('sender_id', $friendId)
                  ->where('receiver_id', $loggedInUser->id);
        })->orderBy('created_at', 'asc')
        ->get();

        Message::where('receiver_id', $loggedInUser->id)
               ->where('sender_id', $friendId)
               ->where('is_read', false)
               ->update(['is_read' => true]);

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request, $receiverId)
    {
        $loggedInUser = Auth::user();

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => $loggedInUser->id,
            'receiver_id' => $receiverId,
            'content' => $request->input('content'),
        ]);

        return response()->json(['message' => $message]);
    }
}
