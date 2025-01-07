@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <div style="border: 2px solid black;border-radius: 5px;width:fit-content">
            <a href="{{ route('home') }}" class="p-2 d-flex align-items-center text-decoration-none"
                style="color:black;width:100%">
                <img src="{{ asset('assets/back.png') }}" alt="Arrow" width="15" height="15">
                <p class="m-0 ps-2">Back</p>
            </a>
        </div>
        <h1>{{ $user->username }} Profiles</h1>
        <div class="text-center mb-4">
            <img src="{{ $user->profile_picture }}" alt="{{ $user->username }}" class="rounded-circle" width="200"
                height="200">
        </div>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Username:</strong> {{ $user->username }}</li>
            <li class="list-group-item"><strong>Gender:</strong> {{ $user->gender }}</li>
            <li class="list-group-item"><strong>Phone number:</strong> {{ $user->phone_number }}</li>
            <li class="list-group-item"><strong>Hobbies:</strong> {{ $user->hobbies }}</li>
            <li class="list-group-item"><strong>Instagram: </strong><a
                    href="{{ $user->instagram_link }}">{{ $user->instagram_link }}</a></li>
            <li class="list-group-item"><strong>Date joined:</strong> {{ $user->created_at->format('F j, Y') }}</li>
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
                    {{-- already friends --}}
                    <form action="{{ route('user.remove.friend', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Remove Friend</button>
                    </form>
                @elseif ($loggedInUser->sentFriendRequests->where('receiver_id', $user->id)->count())
                    {{-- friend request is already sent --}}
                    <button type="button" class="btn btn-warning" disabled>Friend Request Sent</button>
                @elseif ($loggedInUser->receivedFriendRequests->where('sender_id', $user->id)->count())
                    {{-- there is a friend request to accept or reject --}}
                    <form action="{{ route('user.accept.friend', $user->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">Accept Friend Request</button>
                    </form>
                    <form action="{{ route('user.reject.friend', $user->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Reject Friend Request</button>
                    </form>
                @else
                    {{-- no friend request exists --}}
                    <form action="{{ route('user.add.friend', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Add Friend</button>
                    </form>
                @endif
            @endif
        @endauth

        @guest
            <p class="text-muted">Login to add this user as a friend.</p>
        @endguest
    </div>
@endsection
