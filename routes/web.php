<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthenticateUser;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::match(['GET', 'POST'], '/logout', [LogoutController::class, 'logout'])->name('logout');

Route::prefix('register')->group(function () {
    Route::get('/', [RegisterController::class, 'index'])->name('register');
    Route::post('/', [RegisterController::class, 'register'])->name('register.submit');
    Route::get('/payment', [RegisterController::class, 'showPayment'])->name('register.payment');
    Route::post('/payment', [RegisterController::class, 'processPayment'])->name('register.payment.process');
});

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('set-locale');

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::middleware([AuthenticateUser::class])->prefix('user')->group(function () {
    Route::get('/{id}', [UserController::class, 'show'])->name('user.show');
    Route::post('/{id}/add-friend', [UserController::class, 'addFriend'])->name('user.add.friend');
    Route::post('/{id}/remove-friend', [UserController::class, 'removeFriend'])->name('user.remove.friend');
    Route::post('/{id}/accept-friend', [UserController::class, 'acceptFriendRequest'])->name('user.accept.friend');
    Route::post('/{id}/reject-friend', [UserController::class, 'rejectFriendRequest'])->name('user.reject.friend');
});

Route::middleware([AuthenticateUser::class])->prefix('chat')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('chat');
    Route::post('/send/{receiverId}', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/fetch/{friendId}', [ChatController::class, 'fetchMessages'])->name('chat.fetch');
});

Route::middleware([AuthenticateUser::class])->prefix('avatar')->group(function () {
    Route::get('/', [AvatarController::class, 'index'])->name('avatar');
    Route::post('/buy/{id}', [AvatarController::class, 'buy'])->name('avatar.buy');
});

Route::middleware([AuthenticateUser::class])->prefix('topup')->group(function () {
    Route::get('/', [TopupController::class, 'index'])->name('topup');
    Route::post('/buy', [TopupController::class, 'buy'])->name('topup.buy');
});

Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('set-locale');