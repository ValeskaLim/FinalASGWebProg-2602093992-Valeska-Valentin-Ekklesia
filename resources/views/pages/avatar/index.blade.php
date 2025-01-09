@extends('layout.master')

@section('content')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between my-3">
            <h1 class="m-0">Avatars</h1>
            <h3 class="m-0 text-center fs-5" style="color: {{ $user->wallet == 0 ? 'red' : 'green' }};">
                @lang('messages.your_wallet_avatars', ['wallet' => $user->wallet])
            </h3>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @elseif(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            @foreach ($avatars as $avatar)
                <div class="col-md-3">
                    <div class="card mb-4">
                        <img src="{{ $avatar->image_url }}" alt="{{ $avatar->name }}" class="card-img-top" width="100"
                            height="100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $avatar->name }}</h5>
                            <p class="card-text">@lang('messages.price_card'){{ number_format($avatar->price, 2) }}</p>

                            @if ($user->avatars->contains($avatar))
                                <button type="button" class="btn btn-secondary" disabled>@lang('messages.avatar_bought_message')</button>
                            @else
                                @if ($user->wallet >= $avatar->price)
                                    <form action="{{ route('avatar.buy', $avatar->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">@lang('messages.buy')</button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-danger" disabled>@lang('messages.insufficient_fund')</button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
