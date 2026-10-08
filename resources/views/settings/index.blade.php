@extends('layouts.app')
@section('title', 'System Settings')
@section('content')
<h1 class="page-heading">System Settings</h1>

<form class="page-card" method="POST" action="{{ route('settings.update') }}">
    @csrf
    @method('PUT')

    <label for="site_name">Site name</label>
    <input id="site_name" name="site_name" value="{{ old('site_name', $siteName) }}" required>
    @error('site_name') <p class="form-error">{{ $message }}</p> @enderror

    <label>
        <input type="checkbox" name="allow_registration" value="1" @checked(old('allow_registration', $allowRegistration))>
        Allow public registration
    </label>

    <button type="submit">Save settings</button>
</form>
@endsection
