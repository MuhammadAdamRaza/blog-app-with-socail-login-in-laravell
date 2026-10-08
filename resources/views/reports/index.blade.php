@extends('layouts.app')
@section('title', 'System Reports')
@section('content')
<h1 class="page-heading">System Reports</h1>

<section class="page-card">
    <div class="record-list">
        <p>Total users: <strong>{{ $totalUsers }}</strong></p>
        <p>Total projects: <strong>{{ $totalProjects }}</strong></p>
        <p>Total posts: <strong>{{ $totalPosts }}</strong></p>
        <p>Total roles: <strong>{{ $totalRoles }}</strong></p>
    </div>
</section>

<section class="page-card">
<h2>Projects by status</h2>
@forelse ($projectsByStatus as $row)
    <p>{{ ucfirst($row->status) }}: {{ $row->total }}</p>
@empty
    <p>No projects are available yet.</p>
@endforelse
</section>
@endsection
