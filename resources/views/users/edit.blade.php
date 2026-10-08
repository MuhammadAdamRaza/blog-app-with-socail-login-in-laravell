@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-heading">Edit User</h1>
        <p class="page-subheading">Update this account’s profile and access.</p>
    </div>
    <a class="btn btn-secondary" href="{{ route('users.index') }}">Back to users</a>
</div>

<form class="page-card" method="POST" action="{{ route('users.update', $user) }}" data-confirm="Save these changes to this user account?">
    @csrf
    @method('PUT')

    <div class="user-summary">
        <span class="user-avatar" aria-hidden="true">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
        <div>
            <span class="user-summary-name">{{ $user->name }}</span>
            <span class="user-summary-email">{{ $user->email }}</span>
        </div>
    </div>

    <div class="user-edit-grid">
        <div class="field-group">
            <label for="name">Full name</label>
            <input id="name" name="name" value="{{ old('name', $user->name) }}" autocomplete="name" required>
            @error('name') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="field-group">
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" autocomplete="email" required>
            @error('email') <p class="form-error">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="action-row">
        <button class="btn" type="submit">Save changes</button>
        <a class="btn btn-secondary" href="{{ route('users.index') }}">Cancel</a>
    </div>
</form>

@can('roles.assign')
    <section class="page-card">
        <h2>Account role</h2>
        <p class="page-subheading">Choose which areas this user can access.</p>
        <form method="POST" action="{{ route('users.assign-role', $user) }}" data-confirm="Update this user's role?">
            @csrf

            <div class="field-group">
                <label for="role_id">Role</label>
                <select id="role_id" name="role_id" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected($user->roles->contains('id', $role->id))>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <button class="btn" type="submit">Update role</button>
        </form>
    </section>
@endcan
@endsection
