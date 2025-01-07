@extends('layout.master')

@section('content')
    <div class="container d-flex justify-content-center mt-5">
        <div class="d-flex flex-column text-center">
            <img src="{{ $loggedInUser->profile_picture }}" alt="{{ $loggedInUser->username }}" width="250" height="250"
                class="rounded-circle">
            <h1>{{ $loggedInUser->username }}</h1>
            <h3>
                Your wallet is
                <strong class="{{ $loggedInUser->wallet == 0 ? 'text-danger' : 'text-success' }}">
                    ${{ $loggedInUser->wallet }}
                </strong>
            </h3>

            <form action="{{ route('topup.buy') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary fs-5 mt-5">
                    Topup Here! (+100 coins)
                </button>
            </form>
        </div>
    </div>
@endsection