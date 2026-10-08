<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\PermissionManagementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Models\Setting;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SocialAuthController;

Route::get('/', function () {
    $user = Auth::user();

    if (! $user) {
        $posts = collect();
    } elseif ($user->hasRole('super-admin') || $user->hasRole('editor')) {
        $posts = Post::with('user')->latest()->get();
    } elseif ($user->hasRole('user')) {
        $posts = $user->assignedPosts()
            ->with('user')
            ->latest('posts.created_at')
            ->get();
    } else {
        $posts = collect();
    }

    $latestPost = $posts->first();
    $siteName = Setting::where('key', 'site_name')->value('value') ?: 'My Blog';

    return view('home', [
        'posts' => $posts,
        'latestPost' => $latestPost,
        'currentUserId' => Auth::id(),
        'currentUserName' => $user?->name,
        'siteName' => $siteName,
    ]);
})->name('home');
Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])
    ->middleware('throttle:10,1')
    ->name('auth.google.redirect');

Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])
    ->middleware('throttle:10,1')
    ->name('auth.google.callback');

Route::get('/auth/github/redirect', [SocialAuthController::class, 'redirectToGithub'])
    ->middleware('throttle:10,1')
    ->name('auth.github.redirect');

Route::get('/auth/github/callback', [SocialAuthController::class, 'handleGithubCallback'])
    ->middleware('throttle:10,1')
    ->name('auth.github.callback');

Route::get('/auth/linkedin/redirect', [SocialAuthController::class, 'redirectToLinkedin'])
    ->middleware('throttle:10,1')
    ->name('auth.linkedin.redirect');

Route::get('/auth/linkedin/callback', [SocialAuthController::class, 'handleLinkedinCallback'])
    ->middleware('throttle:10,1')
    ->name('auth.linkedin.callback');

Route::get('/auth/facebook/redirect', [SocialAuthController::class, 'redirectToFacebook'])
    ->middleware('throttle:10,1')
    ->name('auth.facebook.redirect');

Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback'])
    ->middleware('throttle:10,1')
    ->name('auth.facebook.callback');

Route::get('/register', fn() => view('register'))->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.store');
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.store');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/reports', [ReportController::class, 'index'])
        ->middleware('permission:reports.view')
        ->name('reports.index');
    Route::get('/settings', [SettingsController::class, 'index'])
        ->middleware('permission:settings.manage')
        ->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])
        ->middleware('permission:settings.manage')
        ->name('settings.update');

    Route::get('/roles', [RoleManagementController::class, 'index'])
        ->middleware('permission:roles.manage')
        ->name('roles.index');
    Route::get('/roles/create', [RoleManagementController::class, 'create'])
        ->middleware('permission:roles.manage')
        ->name('roles.create');
    Route::post('/roles', [RoleManagementController::class, 'store'])
        ->middleware('permission:roles.manage')
        ->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleManagementController::class, 'edit'])
        ->middleware('permission:roles.manage')
        ->name('roles.edit');
    Route::put('/roles/{role}', [RoleManagementController::class, 'update'])
        ->middleware('permission:roles.manage')
        ->name('roles.update');
    Route::delete('/roles/{role}', [RoleManagementController::class, 'destroy'])
        ->middleware('permission:roles.manage')
        ->name('roles.destroy');

    Route::get('/permissions', [PermissionManagementController::class, 'index'])
        ->middleware('permission:permissions.manage')
        ->name('permissions.index');
    Route::get('/permissions/create', [PermissionManagementController::class, 'create'])
        ->middleware('permission:permissions.manage')
        ->name('permissions.create');
    Route::post('/permissions', [PermissionManagementController::class, 'store'])
        ->middleware('permission:permissions.manage')
        ->name('permissions.store');
    Route::get('/permissions/{permission}/edit', [PermissionManagementController::class, 'edit'])
        ->middleware('permission:permissions.manage')
        ->name('permissions.edit');
    Route::put('/permissions/{permission}', [PermissionManagementController::class, 'update'])
        ->middleware('permission:permissions.manage')
        ->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionManagementController::class, 'destroy'])
        ->middleware('permission:permissions.manage')
        ->name('permissions.destroy');

    Route::get('/users', [UserManagementController::class, 'index'])
        ->middleware('permission:users.view')
        ->name('users.index');
    Route::get('/users/trashed', [UserManagementController::class, 'trashed'])
        ->middleware('permission:users.delete')
        ->name('users.trashed');
    Route::get('/users/create', [UserManagementController::class, 'create'])
        ->middleware('permission:users.create')
        ->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])
        ->middleware('permission:users.create')
        ->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])
        ->middleware('permission:users.update')
        ->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])
        ->middleware('permission:users.update')
        ->name('users.update');
    Route::post('/users/{user}/role', [UserManagementController::class, 'assignRole'])
        ->middleware(['permission:roles.assign', 'can:update,user'])
        ->name('users.assign-role');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])
        ->middleware('permission:users.delete')
        ->name('users.destroy');
    Route::post('/users/{id}/restore', [UserManagementController::class, 'restore'])
        ->middleware('permission:users.delete')
        ->name('users.restore');
    Route::delete('/users/{id}/force-delete', [UserManagementController::class, 'forceDelete'])
        ->middleware('permission:users.delete')
        ->name('users.force-delete');

    Route::post('/create-post', [PostController::class, 'store'])
        ->middleware('permission:posts.create')
        ->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])
        ->middleware('permission:posts.update')
        ->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->middleware('permission:posts.delete')
        ->name('posts.destroy');
    Route::get('/posts', [PostController::class, 'index'])
        ->middleware('permission:posts.view')
        ->name('posts.index');
    Route::post('/posts/{post}/assign', [PostController::class, 'assignUser'])
        ->middleware('permission:posts.assign')
        ->name('posts.assign');

    Route::get('/projects', [ProjectController::class, 'index'])
        ->middleware('permission:projects.view')
        ->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])
        ->middleware('permission:projects.create')
        ->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])
        ->middleware('permission:projects.create')
        ->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])
        ->middleware(['permission:projects.view', 'can:view,project'])
        ->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])
        ->middleware(['permission:projects.update', 'can:update,project'])
        ->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])
        ->middleware(['permission:projects.update', 'can:update,project'])
        ->name('projects.update');
    Route::patch('/projects/{project}/status', [ProjectController::class, 'updateStatus'])
        ->middleware(['permission:projects.status.update', 'can:updateStatus,project'])
        ->name('projects.status.update');
    Route::post('/projects/{project}/assign', [ProjectController::class, 'assignUser'])
        ->middleware(['permission:projects.assign', 'can:assign,project'])
        ->name('projects.assign');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])
        ->middleware(['permission:projects.delete', 'can:delete,project'])
        ->name('projects.destroy');
});

Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])
    ->middleware(['guest', 'throttle:5,1'])
    ->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
    ->middleware(['guest', 'throttle:5,1'])
    ->name('password.update');
