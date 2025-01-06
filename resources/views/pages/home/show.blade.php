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

        h1, h2 {
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

        {{-- Search Results Header --}}
        <h1 class="text-center mb-4">Search Results</h1>

        {{-- Display Message if No Results --}}
        @if ($otherUsers->isEmpty())
            <div class="text-center mt-4">
                <p class="fs-4 text-muted">
                    No users found for your search.
                </p>
            </div>
        @else
            {{-- Display Search Results --}}
            <div class="row">
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
            </div>
        @endif
    </div>
@endsection
