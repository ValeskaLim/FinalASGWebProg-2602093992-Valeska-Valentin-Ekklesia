<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $loggedInUser = Auth::user();

        if (!$loggedInUser && $request->has('search')) {
            return redirect()->route('login')->with('error', 'Please login to search.');
        }

        $search = $request->input('search');
        $gender = $request->input('gender');
        $hobbies = $request->input('hobbies');

        if ($loggedInUser) {
            $friends = $loggedInUser->friends()->when($search, function ($query) use ($search) {
                    return $query->where('username', 'like', '%' . $search . '%');
                })
                ->when($gender, function ($query) use ($gender) {
                    return $query->where('gender', $gender);
                })
                ->when($hobbies, function ($query) use ($hobbies) {
                    return $query->where('hobbies', 'like', '%' . $hobbies . '%');
                })
                ->get();

            $friendIds = $friends->pluck('id')->toArray();
            $friendIds[] = $loggedInUser->id; // Exclude logged-in user

            $otherUsers = User::whereNotIn('id', $friendIds)
                ->when($search, function ($query) use ($search) {
                    return $query->where('username', 'like', '%' . $search . '%');
                })
                ->when($gender, function ($query) use ($gender) {
                    return $query->where('gender', $gender);
                })
                ->when($hobbies, function ($query) use ($hobbies) {
                    return $query->where('hobbies', 'like', '%' . $hobbies . '%');
                })
                ->get();
        } else {
            $friends = collect();

            $otherUsers = User::when($search, function ($query) use ($search) {
                    return $query->where('username', 'like', '%' . $search . '%');
                })
                ->when($gender, function ($query) use ($gender) {
                    return $query->where('gender', $gender);
                })
                ->when($hobbies, function ($query) use ($hobbies) {
                    return $query->where('hobbies', 'like', '%' . $hobbies . '%');
                })
                ->get();
        }

        foreach ($friends as $friend) {
            $friend->profile_picture = 'https://ui-avatars.com/api/?name=' . urlencode($friend->username) . '&background=random';
        }

        foreach ($otherUsers as $user) {
            $user->profile_picture = 'https://ui-avatars.com/api/?name=' . urlencode($user->username) . '&background=random';
        }

        return view('pages.home.index', compact('loggedInUser', 'friends', 'otherUsers'));
    }
}
