@extends('layouts.app')
@section('title', 'Edit Permission')
@section('content')
<h1 class="page-heading">Edit Permission</h1>

<form class="page-card" method="POST" action="{{ route('permissions.update', $permission) }}">
    @csrf
    @method('PUT')

    <label for="name">Permission name</label>
    <input id="name" name="name" value="{{ old('name', $permission->name) }}" required>
    @error('name') <p class="form-error">{{ $message }}</p> @enderror

    <label for="slug">Permission key</label>
    <input id="slug" name="slug" value="{{ old('slug', $permission->slug) }}" required>
    @error('slug') <p class="form-error">{{ $message }}</p> @enderror

    <button type="submit">Save changes</button>
</form>
@endsection
