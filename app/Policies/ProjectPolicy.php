<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('projects.view');
    }

    public function view(User $user, Project $project): bool
    {
        if (! $user->hasPermissionTo('projects.view')) {
            return false;
        }

        if (
            $user->hasRole('super-admin')
            || $user->hasRole('admin')
            || $user->hasRole('manager')
        ) {
            return true;
        }

        return $user->projects()->whereKey($project->id)->exists();
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('projects.create');
    }

    public function update(User $user, Project $project): bool
    {
        return $user->hasPermissionTo('projects.update');
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->hasPermissionTo('projects.delete');
    }

    public function assign(User $user, Project $project): bool
    {
        return $user->hasPermissionTo('projects.assign');
    }

    public function updateStatus(User $user, Project $project): bool
    {
        return $user->hasPermissionTo('projects.status.update');
    }
}
