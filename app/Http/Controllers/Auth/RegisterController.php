<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages.register.index');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:5',
            'gender' => 'required|in:Male,Female',
            'hobbies' => 'required|string|min:3',
            'phone_number' => 'required|numeric|digits_between:1,15|unique:users,phone_number',
            'instagram_link' => 'required|string|url|unique:users,instagram_link',
        ]);

        $hobbiesArray = explode(',', $request->input('hobbies'));
        if (count($hobbiesArray) < 3) {
            return back()->withErrors(['hobbies' => __('messages.hobbies_error')]);
        }

        $existingUser = User::where('username', $request->input('username'))
            ->orWhere('phone_number', $request->input('phone_number'))
            ->orWhere('instagram_link', $request->input('instagram_link'))
            ->first();

        if ($existingUser) {
            return back()->withErrors([
                'username' => __('messages.user_exist_message'),
            ]);
        }

        if ($request->session()->has('registration_user')) {
            return redirect()->route('register.payment');
        }

        $registrationPrice = rand(100000, 125000);

        $request->session()->put('registration_user', [
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'gender' => $request->input('gender'),
            'hobbies' => $request->input('hobbies'),
            'phone_number' => $request->input('phone_number'),
            'instagram_link' => $request->input('instagram_link'),
            'registration_price' => $registrationPrice,
            'wallet' => 0,
        ]);

        return redirect()->route('register.payment');
    }

    public function showPayment()
    {
        $userData = session('registration_user');

        if (!$userData) {
            return redirect()->route('register')->with('error', __('messages.register_expired'));
        }

        $registrationPrice = $userData['registration_price'];

        return view('pages.register.show', compact('registrationPrice'));
    }

    public function processPayment(Request $request)
    {
        $userData = session('registration_user');

        if (!$userData) {
            return redirect()->route('register')->with('error', __('messages.register_expired'));
        }

        $registrationPrice = $userData['registration_price'];
        $paymentAmount = $request->input('payment_amount');

        $walletAmount = 0;

        $addToWallet = $request->input('add_to_wallet');

        if ($addToWallet === 'yes') {
            $overpaidAmount = $request->session()->get('overpaidAmount', 0);

            $walletAmount = $overpaidAmount;

            User::create([
                'username' => $userData['username'],
                'password' => $userData['password'],
                'gender' => $userData['gender'],
                'hobbies' => $userData['hobbies'],
                'phone_number' => $userData['phone_number'],
                'instagram_link' => $userData['instagram_link'],
                'registration_price' => $userData['registration_price'],
                'wallet' => $overpaidAmount,
            ]);

            $request->session()->forget(['registration_user', 'overpaidAmount']);

            return redirect()->route('login')->with('success', __('messages.register_success_overpaid'));
        }

        if ($paymentAmount > $registrationPrice) {
            $overpaidAmount = $paymentAmount - $registrationPrice;
            $request->session()->put('overpaidAmount', $overpaidAmount);
            return back()->with('overpaid', $overpaidAmount);
        }

        if ($paymentAmount < $registrationPrice) {
            $underpaidAmount = $registrationPrice - $paymentAmount;
            return back()->with('error', __('messages.underpaid_message', ['underpaidAmount' => $underpaidAmount]));
        }

        User::create([
            'username' => $userData['username'],
            'password' => $userData['password'],
            'gender' => $userData['gender'],
            'hobbies' => $userData['hobbies'],
            'phone_number' => $userData['phone_number'],
            'instagram_link' => $userData['instagram_link'],
            'registration_price' => $userData['registration_price'],
            'wallet' => $walletAmount,
        ]);

        $request->session()->forget('registration_user');

        return redirect()->route('login')->with('success', __('messages.register_success'));
    }
}
