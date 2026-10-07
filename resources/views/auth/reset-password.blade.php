@extends('layouts.auth')

@section('title', 'Choose a new password | My Blog')
@section('heading', 'Choose a new password')
@section('description', 'Create a new password for your account, then sign back in securely.')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="form-stack">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-field">
            <label for="email">Email address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $email) }}"
                placeholder="you@example.com"
                autocomplete="email"
                required
                autofocus
            >
        </div>

        <div class="form-field">
            <label for="password">New password</label>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="At least 8 characters"
                autocomplete="new-password"
                minlength="8"
                required
            >
        </div>

        <div class="form-field">
            <label for="password_confirmation">Confirm new password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                placeholder="Enter your password again"
                autocomplete="new-password"
                minlength="8"
                required
            >
        </div>

        <button class="primary-button" type="submit">Save new password</button>
    </form>

    <p class="center-link"><a href="{{ route('login') }}">Back to sign in</a></p>
@endsection
