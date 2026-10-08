@extends('layouts.app')
@section('title', 'Deleted Users')
@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-heading">Deleted users</h1>
        <p class="page-subheading">Restore an account to make it active again.</p>
    </div>
    <a class="btn btn-secondary" href="{{ route('users.index') }}">Back to users</a>
</div>

<div class="record-list">
    @forelse ($users as $user)
        <article class="record-card">
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->email }}</p>
            <p>Role: {{ $user->roles->pluck('name')->join(', ') }}</p>
            <p>Deleted: {{ $user->deleted_at?->format('M j, Y g:i A') }}</p>
            <div class="record-actions">
                <form method="POST" action="{{ route('users.restore', $user->id) }}" data-confirm="Restore this user account?">
                    @csrf
                    <button class="btn" type="submit">Restore user</button>
                </form>
                <form method="POST" action="{{ route('users.force-delete', $user->id) }}" data-confirm="Permanently delete this account and all posts written by this user? This cannot be undone.">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete forever</button>
                </form>
            </div>
        </article>
    @empty
        <p class="empty-state">There are no deleted users.</p>
    @endforelse
</div>

{{ $users->links() }}
@endsection
