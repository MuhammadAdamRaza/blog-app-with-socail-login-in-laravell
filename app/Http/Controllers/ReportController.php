<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function index()
    {
        Gate::authorize('reports.view');

        $totalUsers = User::count();
        $totalProjects = Project::count();
        $totalPosts = Post::count();
        $totalRoles = Role::count();
        $projectsByStatus = Project::query()
            ->select('status')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        return view('reports.index', compact(
            'totalUsers',
            'totalProjects',
            'totalPosts',
            'totalRoles',
            'projectsByStatus'
        ));
    }
}
