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
            return back()->withErrors(['hobbies' => 'Please provide at least 3 hobbies separated by commas.']);
        }

        $existingUser = User::where('username', $request->input('username'))
            ->orWhere('phone_number', $request->input('phone_number'))
            ->orWhere('instagram_link', $request->input('instagram_link'))
            ->first();

        if ($existingUser) {
            return back()->withErrors([
                'username' => 'User already exists with the same username, phone number, or Instagram link.',
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
        ]);

        return redirect()->route('register.payment');
    }

    public function showPayment()
    {
        $userData = session('registration_user');

        if (!$userData) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }

        $registrationPrice = $userData['registration_price'];

        return view('pages.register.show', compact('registrationPrice'));
    }

    public function processPayment(Request $request)
    {
        $userData = session('registration_user');

        if (!$userData) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }

        $registrationPrice = $userData['registration_price'];
        $paymentAmount = $request->input('payment_amount');

        $addToWallet = $request->input('add_to_wallet');

        if ($addToWallet === 'yes') {
            $overpaidAmount = $paymentAmount - $registrationPrice;

            User::create([
                'username' => $userData['username'],
                'password' => $userData['password'],
                'gender' => $userData['gender'],
                'hobbies' => $userData['hobbies'],
                'phone_number' => $userData['phone_number'],
                'instagram_link' => $userData['instagram_link'],
                'registration_price' => $userData['registration_price'],
            ]);

            $request->session()->forget('registration_user');

            return redirect()->route('login')->with('success', 'Payment successful! Registration completed. Your overpaid amount has been added to your wallet.');
        }

        if ($paymentAmount > $registrationPrice) {
            $overpaidAmount = $paymentAmount - $registrationPrice;
            return back()->with('overpaid', $overpaidAmount);
        }

        if ($paymentAmount < $registrationPrice) {
            $underpaidAmount = $registrationPrice - $paymentAmount;
            return back()->with('error', "You are still underpaid by IDR $underpaidAmount. Please enter the exact amount.");
        }

        User::create([
            'username' => $userData['username'],
            'password' => $userData['password'],
            'gender' => $userData['gender'],
            'hobbies' => $userData['hobbies'],
            'phone_number' => $userData['phone_number'],
            'instagram_link' => $userData['instagram_link'],
            'registration_price' => $userData['registration_price'],
        ]);

        $request->session()->forget('registration_user');

        return redirect()->route('login')->with('success', 'Payment successful! Registration completed.');
    }
}
