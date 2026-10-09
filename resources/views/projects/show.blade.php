@extends('layouts.app')
@section('title', $project->name)
@section('content')
<h1 class="page-heading">{{ $project->name }}</h1>

<section class="page-card">
    <p>{{ $project->description ?: 'No description provided.' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($project->status) }}</p>
</section>

<section class="page-card">
@can('updateStatus', $project)
    <form method="POST" action="{{ route('projects.status.update', $project) }}">
        @csrf
        @method('PATCH')

        <label for="status">Project status</label>
        <select id="status" name="status" required>
            <option value="pending" @selected($project->status === 'pending')>Pending</option>
            <option value="active" @selected($project->status === 'active')>Active</option>
            <option value="completed" @selected($project->status === 'completed')>Completed</option>
        </select>

        <button class="btn" type="submit">Update status</button>
    </form>
@endcan

@can('assign', $project)
    <form method="POST" action="{{ route('projects.assign', $project) }}">
        @csrf

        <label for="user_id">Assign team member</label>
        <select id="user_id" name="user_id" required>
            <option value="">Choose a user</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_id') <p class="form-error">{{ $message }}</p> @enderror

        <button class="btn" type="submit">Assign</button>
    </form>
@endcan

<div class="action-row">
    @can('update', $project)
        <a class="btn" href="{{ route('projects.edit', $project) }}">Edit Project</a>
    @endcan

    @can('delete', $project)
        <form method="POST" action="{{ route('projects.destroy', $project) }}" data-confirm="Are you sure you want to delete this project?">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Delete Project</button>
        </form>
    @endcan

    <a class="btn" href="{{ route('projects.index') }}">Back to Projects</a>
</div>
</section>
@endsection
