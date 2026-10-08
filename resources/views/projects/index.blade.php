@extends('layouts.app')
@section('title', 'Projects')
@section('content')
<h1 class="page-heading">Projects</h1>

@can('create', \App\Models\Project::class)
    <div class="action-row" style="margin:0 0 18px"><a class="btn" href="{{ route('projects.create') }}">Create Project</a></div>
@endcan

<div class="record-list">
@forelse ($projects as $project)
    <article class="record-card">
        <h2>
            <a href="{{ route('projects.show', $project) }}">{{ $project->name }}</a>
        </h2>
        <p>{{ $project->description }}</p>
        <p>Status: {{ $project->status }}</p>
    </article>
@empty
    <p class="empty-state">No projects are available yet.</p>
@endforelse
</div>

{{ $projects->links() }}
@endsection
