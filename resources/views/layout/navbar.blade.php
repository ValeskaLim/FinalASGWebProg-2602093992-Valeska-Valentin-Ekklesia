<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container d-flex align-items-center">
        <a class="navbar-brand fs-3" href="{{ route('home') }}">ConnectFriend</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link fs-5" href="{{ route('chat') }}">Chat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="{{ route('avatar') }}">Avatar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="{{ route('topup') }}">Topup</a>
                </li>
                @if (Auth::check())
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">@lang('messages.logout')</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}">
                            <button type="submit" class="btn btn-primary">@lang('messages.login')</button>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('set-locale', 'en') }}" class="btn btn-link">EN</a>
                </li>
                <li class="nasv-item">
                    <a href="{{ route('set-locale', 'id') }}" class="btn btn-link">ID</a>
                </li>
            </ul>
        </div>

    </div>
</nav>
