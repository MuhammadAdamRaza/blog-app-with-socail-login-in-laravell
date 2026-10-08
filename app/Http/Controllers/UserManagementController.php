<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        $users = User::with('roles')->latest()->paginate(15);

        return view('users.index', compact('users'));
    }

    public function trashed()
    {
        Gate::authorize('viewAny', User::class);

        $users = User::onlyTrashed()->with('roles')->latest('deleted_at')->paginate(15);

        return view('users.trashed', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', User::class);

        $roles = Gate::allows('roles.assign')
            ? Role::orderBy('name')->get()
            : collect();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', User::class);

        $canAssignRoles = Gate::allows('roles.assign');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => $canAssignRoles
                ? ['required', 'integer', 'exists:roles,id']
                : ['prohibited'],
        ]);

        $roleId = $canAssignRoles
            ? $validated['role_id']
            : Role::where('slug', 'user')->firstOrFail()->id;
        unset($validated['role_id']);

        $user = User::create($validated);
        $user->roles()->sync([$roleId]);

        return redirect()
            ->route('users.index')
            ->with('status', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);

        $roles = Gate::allows('roles.assign')
            ? Role::orderBy('name')->get()
            : collect();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('status', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('status', 'User moved to the deleted users list.');
    }

    public function restore(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        Gate::authorize('restore', $user);
        $user->restore();

        return redirect()
            ->route('users.trashed')
            ->with('status', 'User restored successfully.');
    }

    public function forceDelete(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        Gate::authorize('forceDelete', $user);

        DB::transaction(function () use ($user): void {
            $user->posts()->delete();
            $user->forceDelete();
        });

        return redirect()
            ->route('users.trashed')
            ->with('status', 'User and authored posts permanently deleted.');
    }

    public function assignRole(Request $request, User $user)
    {
        Gate::authorize('roles.assign');
        Gate::authorize('update', $user);

        $validated = $request->validate([
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ]);

        $user->roles()->sync([$validated['role_id']]);

        return redirect()
            ->route('users.edit', $user)
            ->with('status', 'User role updated.');
    }
}
