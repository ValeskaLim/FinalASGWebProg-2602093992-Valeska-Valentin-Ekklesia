<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthenticateUser;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/about-us', function () {
    return view('about');
});

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