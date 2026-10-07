@extends('layouts.auth')

@section('title', 'Sign in | My Blog')
@section('heading', 'Welcome back')
@section('description', 'Sign in to read and manage your blog posts.')

@section('content')
    <form action="{{ route('login.store') }}" method="POST" class="form-stack">
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

        <div class="form-field">
            <div class="field-label-row">
                <label for="password">Password</label>
                <a href="{{ route('password.request') }}">Forgot password?</a>
            </div>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="Enter your password"
                autocomplete="current-password"
                required
            >
        </div>

        <button class="primary-button" type="submit">Sign in</button>
    </form>

    @include('partials.social-auth-buttons', ['prompt' => 'Or continue with'])

    <p class="center-link">New to My Blog? <a href="{{ route('register') }}">Create an account</a></p>
@endsection

