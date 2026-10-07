<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SocialAuthController;

Route::get('/', function () {
    $user = Auth::user();
    $posts = $user
        ? Post::where('user_id', $user->id)->with('user')->latest()->get()
        : collect();
    $latestPost = $posts->first();

    return view('home', [
        'posts' => $posts,
        'latestPost' => $latestPost,
        'currentUserId' => Auth::id(),
        'currentUserName' => $user?->name,
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
    Route::post('/create-post', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
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
