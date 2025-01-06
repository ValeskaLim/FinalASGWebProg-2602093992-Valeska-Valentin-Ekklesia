@extends('layout.master')

@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card p-4 shadow rounded" style="width: 400px; background-color: #ffffff;">
            <h3 class="text-center mb-4 fw-bold" style="color: #333;">Login</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label fw-semibold">Username</label>
                    <input type="text" id="username" name="username" class="form-control rounded-2" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" id="password" name="password" class="form-control rounded-2" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-2 fw-bold">Login</button>
                <a href="{{ route('register') }}" class="d-block text-center mt-3 fw-semibold text-decoration-none" style="color: #007bff;">Don't have an account yet? Register Now</a>
            </form>

            @if (session('success'))
                <div class="alert alert-success mt-3 rounded-2">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mt-3 rounded-2">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection
