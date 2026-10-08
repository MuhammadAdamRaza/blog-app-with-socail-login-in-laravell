@extends('layouts.app')
@section('title', 'Create User')
@section('content')
<h1 class="page-heading">Create User</h1>

<form class="page-card" method="POST" action="{{ route('users.store') }}">
    @csrf

    <label for="name">Name</label>
    <input id="name" name="name" value="{{ old('name') }}" required>
    @error('name') <p class="form-error">{{ $message }}</p> @enderror

    <label for="email">Email</label>
    <input id="email" name="email" type="email" value="{{ old('email') }}" required>
    @error('email') <p class="form-error">{{ $message }}</p> @enderror

    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>
    @error('password') <p class="form-error">{{ $message }}</p> @enderror

    <label for="password_confirmation">Confirm password</label>
    <input id="password_confirmation" name="password_confirmation" type="password" required>

    @can('roles.assign')
        <div class="field-group">
            <label for="role_id">Assign role</label>
            <select id="role_id" name="role_id" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected(old('role_id', $roles->firstWhere('slug', 'user')?->id) == $role->id)>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id') <p class="form-error">{{ $message }}</p> @enderror
        </div>
    @endcan

    <button class="btn" type="submit">Create User</button>
</form>
@endsection
