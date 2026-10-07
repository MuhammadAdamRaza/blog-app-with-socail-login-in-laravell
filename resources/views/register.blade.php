@extends('layouts.auth')

@section('title', 'Create account | My Blog')
@section('heading', 'Create your account')
@section('description', 'Join the blog and start sharing your own posts.')

@section('content')
    <form action="{{ route('register.store') }}" method="POST" class="form-stack">
        @csrf

        <div class="form-field">
            <label for="name">Full name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Your name"
                autocomplete="name"
                maxlength="255"
                required
                autofocus
            >
        </div>

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
            >
        </div>

        <div class="form-field">
            <label for="password">Password</label>
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
            <label for="password_confirmation">Confirm password</label>
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

        <button class="primary-button" type="submit">Create account</button>
    </form>

    @include('partials.social-auth-buttons', ['prompt' => 'Or sign up with'])

    <p class="center-link">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
@endsection
