@extends('layouts.app')
@section('title', 'Roles and Permissions')
@section('content')
<h1 class="page-heading">Roles and Permissions</h1>

<div class="action-row" style="margin:0 0 18px"><a class="btn" href="{{ route('roles.create') }}">Create Role</a></div>

<div class="record-list">
@forelse ($roles as $role)
    <article class="record-card">
        <h2>{{ $role->name }}</h2>
        <p>{{ $role->permissions->pluck('name')->join(', ') ?: 'No permissions assigned' }}</p>
        <a class="btn" href="{{ route('roles.edit', $role) }}">Edit Permissions</a>
        @unless (in_array($role->slug, ['super-admin', 'admin', 'manager', 'editor', 'user'], true))
            <form method="POST" action="{{ route('roles.destroy', $role) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Delete Role</button>
            </form>
        @endunless
    </article>
@empty
    <p class="empty-state">No roles found.</p>
@endforelse
</div>

{{ $roles->links() }}
@endsection
