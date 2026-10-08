@extends('layouts.app')
@section('title', 'Users')
@section('content')
<h1 class="page-heading">Users</h1>

@can('create', \App\Models\User::class)
    <div class="action-row" style="margin:0 0 18px"><a class="btn" href="{{ route('users.create') }}">Create User</a></div>
@endcan
@can('users.delete')
    <div class="action-row" style="margin:0 0 18px"><a class="btn btn-secondary" href="{{ route('users.trashed') }}">View deleted users</a></div>
@endcan

<div class="record-list">
@forelse ($users as $user)
    <article class="record-card">
        <h2>{{ $user->name }}</h2>
        <p>{{ $user->email }}</p>
        <p>Role: {{ $user->roles->pluck('name')->join(', ') }}</p>

        @canany(['update', 'delete'], $user)
            <div class="user-actions">
                @can('update', $user)
                    <a class="btn user-action-item" href="{{ route('users.edit', $user) }}" data-confirm="Do you want to open this user for editing?">Edit user</a>
                @endcan

                @can('delete', $user)
                    <form class="user-action-item" method="POST" action="{{ route('users.destroy', $user) }}" data-confirm="Delete this user? This action cannot be undone.">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                @endcan
            </div>
        @endcanany

    </article>
@empty
    <p class="empty-state">No users found.</p>
@endforelse
</div>

{{ $users->links() }}
@endsection
