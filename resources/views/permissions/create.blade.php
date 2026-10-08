@extends('layouts.app')
@section('title', 'Create Permission')
@section('content')
<h1 class="page-heading">Create Permission</h1>

<form class="page-card" method="POST" action="{{ route('permissions.store') }}">
    @csrf

    <label for="name">Permission name</label>
    <input id="name" name="name" value="{{ old('name') }}" required>
    @error('name') <p class="form-error">{{ $message }}</p> @enderror

    <label for="slug">Permission key</label>
    <input id="slug" name="slug" value="{{ old('slug') }}" placeholder="reports.export" required>
    @error('slug') <p class="form-error">{{ $message }}</p> @enderror

    <button type="submit">Create permission</button>
</form>
@endsection
