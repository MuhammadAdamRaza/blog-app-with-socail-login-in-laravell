<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PermissionManagementController extends Controller
{
    public function index()
    {
        Gate::authorize('permissions.manage');

        $permissions = Permission::with('roles')->orderBy('name')->paginate(15);

        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        Gate::authorize('permissions.manage');

        return view('permissions.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('permissions.manage');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:permissions,name'],
            'slug' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9.-]+$/', 'unique:permissions,slug'],
        ]);

        $permission = new Permission();
        $permission->name = $validated['name'];
        $permission->slug = $validated['slug'];
        $permission->save();

        return redirect()->route('permissions.index')->with('status', 'Permission created.');
    }

    public function edit(Permission $permission)
    {
        Gate::authorize('permissions.manage');

        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        Gate::authorize('permissions.manage');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('permissions', 'name')->ignore($permission->id)],
            'slug' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9.-]+$/', Rule::unique('permissions', 'slug')->ignore($permission->id)],
        ]);

        $permission->name = $validated['name'];
        $permission->slug = $validated['slug'];
        $permission->save();

        return redirect()->route('permissions.index')->with('status', 'Permission updated.');
    }

    public function destroy(Permission $permission)
    {
        Gate::authorize('permissions.manage');

        $permission->delete();

        return redirect()->route('permissions.index')->with('status', 'Permission deleted.');
    }
}
