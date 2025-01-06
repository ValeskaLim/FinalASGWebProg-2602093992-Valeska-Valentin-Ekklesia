@extends('layout.master')

@section('content')
    <style>
        .user-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .user-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .user-card img {
            object-fit: cover;
            border: 3px solid #E8E8E8;
        }

        .user-card h5 {
            color: #333;
        }

        .user-card p {
            font-size: 0.9rem;
            color: #555;
        }

        .alert {
            font-size: 1rem;
            font-weight: 500;
        }

        h1,
        h2 {
            font-weight: 700;
            color: #444;
        }
    </style>

    <div class="container mt-4">
        {{-- Alert Messages --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Search Bar --}}
        <form method="GET" action="{{ url('/home') }}" class="mb-4">
            <div class="row">
                <div class="col-6">
                    <input type="text" name="search" class="form-control" placeholder="Search users..."
                        value="{{ request()->input('search') }}">
                </div>
                <div class="col-2">
                    <select name="gender" class="form-control">
                        <option value="">All Genders</option>
                        <option value="Male" {{ request()->input('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request()->input('gender') == 'Female' ? 'selected' : '' }}>Female
                        </option>
                    </select>
                </div>
                <div class="col-3">
                    <input type="text" name="hobbies" class="form-control" placeholder="Hobbies"
                        value="{{ request()->input('hobbies') }}">
                </div>
                <div class="col-1">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        {{-- Your Content --}}
        <h1 class="text-center mb-4">Welcome back, {{ $loggedInUser ? $loggedInUser->username : 'Guest' }}!</h1>

        {{-- Friends Section --}}
        <h2 class="mt-4">Your Friends</h2>
        @if ($friends->isNotEmpty())
            <div class="row">
                @foreach ($friends as $friend)
                    <div class="col-12 col-sm-6 col-md-3 mb-4">
                        <a href="{{ route('user.show', $friend->id) }}" class="text-decoration-none">
                            <div class="user-card text-center bg-white p-4 shadow-sm rounded">
                                <img src="{{ $friend->profile_picture }}" alt="{{ $friend->username }}'s profile picture"
                                    width="100" height="100" class="rounded-circle mb-3">
                                <h5 class="fw-bold">{{ $friend->username }}</h5>
                                <p class="m-0 text-muted"><strong>Hobbies</strong></p>
                                <p class="text-muted">{{ $friend->hobbies }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center mt-4">
                <p class="fs-4 text-muted">
                    {{ $loggedInUser ? "You don't have any friends yet." : 'Login to see your friends' }}
                </p>
            </div>
        @endif

        {{-- Other Users Section --}}
        <h2 class="mt-5">Other Users</h2>
        <div class="row">
            @if ($otherUsers->isNotEmpty())
                @foreach ($otherUsers as $user)
                    <div class="col-12 col-sm-6 col-md-3 mb-4">
                        <a href="{{ route('user.show', $user->id) }}" class="text-decoration-none">
                            <div class="user-card text-center bg-white p-4 shadow-sm rounded">
                                <img src="{{ $user->profile_picture }}" alt="{{ $user->username }}'s profile picture"
                                    width="100" height="100" class="rounded-circle mb-3">
                                <h5 class="fw-bold">{{ $user->username }}</h5>
                                <p class="m-0 text-muted"><strong>Hobbies</strong></p>
                                <p class="text-muted">{{ $user->hobbies }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="text-center mt-4">
                    <p class="fs-4 text-muted">
                        There are currently no users to display.
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
