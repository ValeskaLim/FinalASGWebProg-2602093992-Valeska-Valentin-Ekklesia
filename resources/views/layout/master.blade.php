<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ConnectFriend')</title>
    <link rel="icon" href="{{ asset('/assets/logo.webp') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
</head>
<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    }

    main {
        flex: 1;
    }
</style>

<body>
    @unless (request()->routeIs('login', 'register', 'register.payment'))
        @include('layout.navbar')
    @endunless

    <main>
        @yield('content')
    </main>

    @unless (request()->routeIs('login', 'register', 'register.payment'))
        @include('layout.footer')
    @endunless

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


</body>

</html>
