@extends('layouts.app')
@section('title', 'Posts')
@section('content')
<h1 class="page-heading">Posts</h1>

@can('create', \App\Models\Post::class)
    <div class="action-row" style="margin:0 0 18px"><a class="btn" href="{{ route('home') }}#create-post">Create Post</a></div>
@endcan

<div class="record-list">
@forelse ($posts as $post)
    <article class="record-card">
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->body }}</p>
        <p>By: {{ $post->user->name ?? 'Unknown author' }}</p>

        @can('update', $post)
            <details>
                <summary>Edit post</summary>
                <form method="POST" action="{{ route('posts.update', $post) }}">
                    @csrf
                    @method('PUT')

                    <label for="title-{{ $post->id }}">Title</label>
                    <input id="title-{{ $post->id }}" name="title" value="{{ $post->title }}" required>

                    <label for="body-{{ $post->id }}">Content</label>
                    <textarea id="body-{{ $post->id }}" name="body" required>{{ $post->body }}</textarea>

                <button type="submit">Save changes</button>
                </form>
            </details>
        @endcan

        @can('delete', $post)
            <form method="POST" action="{{ route('posts.destroy', $post) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Delete post</button>
            </form>
        @endcan

        @can('posts.assign')
            <form method="POST" action="{{ route('posts.assign', $post) }}">
                @csrf
                <label for="user-{{ $post->id }}">Assign to user</label>
                <select id="user-{{ $post->id }}" name="user_id" required>
                    <option value="">Choose a user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <button type="submit">Assign post</button>
            </form>
        @endcan
    </article>
@empty
    <p class="empty-state">No posts are available yet.</p>
@endforelse
</div>

{{ $posts->links() }}
@endsection
