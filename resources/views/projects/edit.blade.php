@extends('layouts.app')
@section('title', 'Edit Project')
@section('content')
<h1 class="page-heading">Edit Project</h1>

<form class="page-card" method="POST" action="{{ route('projects.update', $project) }}">
    @csrf
    @method('PUT')

    <label for="name">Project name</label>
    <input
        id="name"
        name="name"
        value="{{ old('name', $project->name) }}"
        required
    >
    @error('name') <p class="form-error">{{ $message }}</p> @enderror

    <label for="description">Description</label>
    <textarea id="description" name="description">{{ old('description', $project->description) }}</textarea>
    @error('description') <p class="form-error">{{ $message }}</p> @enderror

    <button type="submit">Save changes</button>
</form>
@endsection
