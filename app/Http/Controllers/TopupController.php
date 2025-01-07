<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    public function index() {
        $loggedInUser = Auth::user();

        $loggedInUser->profile_picture = 'https://ui-avatars.com/api/?name=' . urlencode($loggedInUser->username) . '&background=random';

        return view('pages.topup.index', compact('loggedInUser'));
    }

    public function buy() {
        $loggedInUser = Auth::user();

        $loggedInUser->wallet += 100;
        $loggedInUser->save();

        return redirect()->route('topup');
    }
}
