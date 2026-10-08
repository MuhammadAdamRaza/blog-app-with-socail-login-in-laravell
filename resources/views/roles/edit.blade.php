@extends('layouts.app')
@section('title', 'Edit Role Permissions')
@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-heading">Edit Permissions</h1>
        <p class="page-subheading">Choose access permissions for the {{ $role->name }} role.</p>
    </div>
    <a class="btn btn-secondary" href="{{ route('roles.index') }}">Back to roles</a>
</div>

<form class="page-card" method="POST" action="{{ route('roles.update', $role) }}">
    @csrf
    @method('PUT')

    <div class="permission-list">
    @foreach ($permissions as $permission)
        <label class="permission-option">
            <input
                type="checkbox"
                name="permissions[]"
                value="{{ $permission->id }}"
                @checked($role->permissions->contains('id', $permission->id))
            >
            <span>
                <strong>{{ $permission->name }}</strong>
                <small style="display:block;color:#64748b">{{ $permission->slug }}</small>
            </span>
        </label>
    @endforeach
    </div>

    <div class="action-row">
        <button class="btn" type="submit">Save permissions</button>
        <a class="btn btn-secondary" href="{{ route('roles.index') }}">Cancel</a>
    </div>
</form>
@endsection
