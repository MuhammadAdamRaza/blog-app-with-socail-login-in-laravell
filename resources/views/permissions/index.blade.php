@extends('layouts.app')
@section('title', 'Permissions')
@section('content')
<h1 class="page-heading">Permissions</h1>

<div class="action-row" style="margin:0 0 18px"><a class="btn" href="{{ route('permissions.create') }}">Create Permission</a></div>

<div class="record-list">
@forelse ($permissions as $permission)
    <article class="record-card">
        <h2>{{ $permission->name }}</h2>
        <p>Key: {{ $permission->slug }}</p>
        <p>Roles: {{ $permission->roles->pluck('name')->join(', ') ?: 'None' }}</p>
        <div class="record-actions">
            <a class="btn" href="{{ route('permissions.edit', $permission) }}">Edit</a>
            <form method="POST" action="{{ route('permissions.destroy', $permission) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Delete</button>
            </form>
        </div>
    </article>
@empty
    <p class="empty-state">No permissions found.</p>
@endforelse
</div>

{{ $permissions->links() }}
@endsection
