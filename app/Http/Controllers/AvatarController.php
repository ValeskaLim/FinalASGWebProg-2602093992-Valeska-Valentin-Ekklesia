<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvatarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $avatars = Avatar::all();

        return view('pages.avatar.index', compact('avatars', 'user'));
    }

    public function buy(Request $request, $id)
    {
        $loggedInUser = Auth::user();
        $avatar = Avatar::findOrFail($id);

        if ($loggedInUser->avatars->contains($avatar)) {
            return back()->with('error', 'You already bought this avatar.');
        }

        $avatarPrice = $avatar->price;

        if ($loggedInUser->wallet < $avatarPrice) {
            return back()->with('error', 'You do not have enough balance to purchase this avatar.');
        }

        $loggedInUser->wallet -= $avatarPrice;
        $loggedInUser->avatars()->attach($avatar);

        $loggedInUser->save();

        return back()->with('success', 'Avatar purchased successfully!');
    }
}
