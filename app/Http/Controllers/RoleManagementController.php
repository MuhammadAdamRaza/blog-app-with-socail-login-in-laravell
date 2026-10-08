<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleManagementController extends Controller
{
    public function index()
    {
        Gate::authorize('roles.manage');

        $roles = Role::with('permissions')->orderBy('name')->paginate(15);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        Gate::authorize('roles.manage');

        $permissions = Permission::orderBy('name')->get();

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        Gate::authorize('roles.manage');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name'],
            'slug' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9-]+$/', 'unique:roles,slug'],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        $role = new Role();
        $role->name = $validated['name'];
        $role->slug = $validated['slug'];
        $role->save();
        $role->permissions()->sync($validated['permissions'] ?? []);

        return redirect()->route('roles.index')->with('status', 'Role created.');
    }

    public function edit(Role $role)
    {
        Gate::authorize('roles.manage');

        $permissions = Permission::orderBy('name')->get();

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        Gate::authorize('roles.manage');

        $validated = $request->validate([
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        $role->permissions()->sync($validated['permissions'] ?? []);

        return redirect()->route('roles.index')->with('status', 'Role permissions updated.');
    }

    public function destroy(Role $role)
    {
        Gate::authorize('roles.manage');

        abort_if(
            in_array($role->slug, ['super-admin', 'admin', 'manager', 'editor', 'user'], true),
            403,
            'Built-in roles cannot be deleted.'
        );

        abort_if($role->users()->exists(), 422, 'This role is assigned to users.');

        $role->delete();

        return redirect()->route('roles.index')->with('status', 'Role deleted.');
    }
}
