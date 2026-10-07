@extends('layouts.auth')

@section('title', 'Forgot password | My Blog')
@section('heading', 'Forgot your password?')
@section('description', 'No worries. Enter your email address and we\'ll send you a reset link.')

@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="form-stack">
        @csrf

        <div class="form-field">
            <label for="email">Email address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="you@example.com"
                autocomplete="email"
                required
                autofocus
            >
        </div>

        <button class="primary-button" type="submit">Send reset link</button>
    </form>

    <p class="center-link"><a href="{{ route('login') }}">&larr; Back to sign in</a></p>
@endsection