@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <div style="border: 2px solid black;border-radius: 5px;width:fit-content">
            <a href="{{ route('home') }}" class="p-2 d-flex align-items-center text-decoration-none"
                style="color:black;width:100%">
                <img src="{{ asset('assets/back.png') }}" alt="Arrow" width="15" height="15">
                <p class="m-0 ps-2">@lang('messages.back')</p>
            </a>
        </div>
        <h1>@lang('messages.user_profile_name', ['username' => $user->username])</h1>
        <div class="text-center mb-4">
            <img src="{{ $user->profile_picture }}" alt="{{ $user->username }}" class="rounded-circle" width="200"
                height="200">
        </div>
        <ul class="list-group mb-4">
            <li class="list-group-item">@lang('messages.username_detail', ['username' => $user->username])</li>
            <li class="list-group-item">@lang('messages.gender_detail', ['gender' => $user->gender])</li>
            <li class="list-group-item">@lang('messages.phone_number_detail', ['phone_number' => $user->phone_number])</li>
            <li class="list-group-item">@lang('messages.hobbies_detail', ['hobbies' => $user->hobbies])</li>
            <li class="list-group-item">@lang('messages.instagram_link_detail')<a
                    href="{{ $user->instagram_link }}">{{ $user->instagram_link }}</a></li>
            <li class="list-group-item">@lang('messages.date_joined_detail', ['date_joined' => $user->created_at->format('F j, Y')])</li>
        </ul>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @auth
            @if ($loggedInUser->id !== $user->id)
                @if ($isFriend)
                    <form action="{{ route('user.remove.friend', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">@lang('messages.remove_friend')</button>
                    </form>
                @elseif ($loggedInUser->sentFriendRequests->where('receiver_id', $user->id)->count())
                    <button type="button" class="btn btn-warning" disabled>@lang('messages.friend_request_sent')</button>
                @elseif ($loggedInUser->receivedFriendRequests->where('sender_id', $user->id)->count())
                    <form action="{{ route('user.accept.friend', $user->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">@lang('messages.accept_friend')</button>
                    </form>
                    <form action="{{ route('user.reject.friend', $user->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">@lang('messages.reject_friend')</button>
                    </form>
                @else
                    <form action="{{ route('user.add.friend', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">@lang('messages.add_friend')</button>
                    </form>
                @endif
            @endif
        @endauth

        @guest
            <p class="text-muted">@lang('messages.guest_add_friend')</p>
        @endguest
    </div>
@endsection
