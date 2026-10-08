<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Project::class);

        $user = $request->user();

        $projects = $user->hasRole('user')
            ? $user->projects()->orderByDesc('projects.created_at')->paginate(10)
            : Project::query()->latest()->paginate(10);

        return view('projects.index', compact('projects'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Project::class);

        return view('projects.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Project::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $project = new Project($validated);
        $project->creator()->associate($request->user());
        $project->save();

        return redirect()
            ->route('projects.index')
            ->with('status', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        Gate::authorize('view', $project);

        $users = Gate::allows('assign', $project)
            ? User::whereHas('roles', fn ($query) => $query->where('slug', 'user'))
                ->whereDoesntHave('projects', function ($query) use ($project) {
                    $query->where('projects.id', $project->id);
                })
                ->orderBy('name')
                ->get(['id', 'name'])
            : collect();

        return view('projects.show', compact('project', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        Gate::authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        Gate::authorize('update', $project);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $project->update($validated);

        return redirect()
            ->route('projects.show', $project)
            ->with('status', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        Gate::authorize('delete', $project);

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('status', 'Project deleted successfully.');
    }

    public function updateStatus(Request $request, Project $project)
    {
        Gate::authorize('updateStatus', $project);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,active,completed'],
        ]);

        $project->update($validated);

        return redirect()
            ->route('projects.show', $project)
            ->with('status', 'Project status updated successfully.');
    }

    public function assignUser(Request $request, Project $project)
    {
        Gate::authorize('assign', $project);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $member = User::findOrFail($validated['user_id']);
        abort_unless($member->hasRole('user'), 422, 'Projects can only be assigned to users with the User role.');

        $project->users()->syncWithoutDetaching([
            $member->id => [
                'assigned_by' => $request->user()->id,
            ],
        ]);

        return redirect()
            ->route('projects.show', $project)
            ->with('status', 'Team member assigned successfully.');
    }
}
