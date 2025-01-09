@extends('layout.master')

@section('content')
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card p-4 shadow rounded" style="width: 400px; background-color: #ffffff;">
            <h3 class="text-center mb-4 fw-bold" style="color: #333;">@lang('messages.payment')</h3>
            <p class="text-center">@lang('messages.payment_price', ['registrationPrice' => $registrationPrice])</p>
            <form method="POST" action="{{ route('register.payment.process') }}">
                @csrf
                <div class="mb-3">
                    <label for="payment_amount" class="form-label fw-semibold">@lang('messages.input_register_payment')</label>
                    <input type="number" id="payment_amount" name="payment_amount" class="form-control rounded-2" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-2 fw-bold">@lang('messages.submit_payment')</button>
            </form>

            @if (session('error'))
                <div class="alert alert-danger mt-3 rounded-2">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('overpaid'))
                <div class="alert alert-warning mt-3 rounded-2">
                    @lang('messages.overpaid_message', ['overpaid' => session('overpaid')])
                    <form method="POST" action="{{ route('register.payment.process') }}" class="d-inline">
                        @csrf
                        <button name="add_to_wallet" value="yes" class="btn btn-link p-0 fw-bold">@lang('messages.yes')</button>
                    </form>
                    <form method="POST" action="{{ route('register.payment.process') }}" class="d-inline">
                        @csrf
                        <button name="add_to_wallet" value="no" class="btn btn-link p-0 fw-bold">@lang('messages.no')</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
