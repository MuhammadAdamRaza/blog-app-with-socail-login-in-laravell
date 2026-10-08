@extends('layouts.app')
@section('title', 'Create Project')
@section('content')
<h1 class="page-heading">Create Project</h1>

<form class="page-card" method="POST" action="{{ route('projects.store') }}">
    @csrf

    <label for="name">Project name</label>
    <input id="name" name="name" value="{{ old('name') }}" required>
    @error('name') <p class="form-error">{{ $message }}</p> @enderror

    <label for="description">Description</label>
    <textarea id="description" name="description">{{ old('description') }}</textarea>
    @error('description') <p class="form-error">{{ $message }}</p> @enderror

    <button type="submit">Create project</button>
</form>
@endsection
