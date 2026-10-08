@extends('layouts.app')
@section('title', 'Create Role')
@section('content')
<h1 class="page-heading">Create Role</h1>

<form class="page-card" method="POST" action="{{ route('roles.store') }}">
    @csrf

    <label for="name">Role name</label>
    <input id="name" name="name" value="{{ old('name') }}" required>
    @error('name') <p class="form-error">{{ $message }}</p> @enderror

    <label for="slug">Role slug</label>
    <input id="slug" name="slug" value="{{ old('slug') }}" placeholder="content-manager" required>
    @error('slug') <p class="form-error">{{ $message }}</p> @enderror

    <h2>Permissions</h2>
    @foreach ($permissions as $permission)
        <label>
            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                @checked(in_array($permission->id, old('permissions', [])))>
            {{ $permission->name }} ({{ $permission->slug }})
        </label>
    @endforeach

    <button type="submit">Create role</button>
</form>
@endsection
