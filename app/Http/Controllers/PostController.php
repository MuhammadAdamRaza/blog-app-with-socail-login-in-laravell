<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Post::class);

        $user = $request->user();

        $posts = $user->hasRole('user')
            ? $user->assignedPosts()->with('user')->latest('posts.created_at')->paginate(10)
            : Post::with(['user', 'assignedUsers'])->latest()->paginate(10);

        $users = Gate::allows('posts.assign')
            ? User::whereHas('roles', fn ($query) => $query->where('slug', 'user'))
                ->orderBy('name')
                ->get(['id', 'name'])
            : collect();

        return view('posts.index', compact('posts', 'users'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Post::class);

        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $request->user()->posts()->create([
            'title' => strip_tags($fields['title']),
            'body' => strip_tags($fields['body']),
        ]);

        return redirect()->route('posts.index')->with('status', 'Your post is published.');
    }

    public function update(Request $request, int $post)
    {
        $post = Post::findOrFail($post);
        Gate::authorize('update', $post);

        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post->update([
            'title' => strip_tags($fields['title']),
            'body' => strip_tags($fields['body']),
        ]);

        return redirect()->route('posts.index')->with('status', 'Your post has been updated.');
    }

    public function destroy(int $post)
    {
        $post = Post::findOrFail($post);
        Gate::authorize('delete', $post);
        $post->delete();

        return redirect()->route('posts.index')->with('status', 'Your post has been deleted.');
    }

    public function assignUser(Request $request, Post $post)
    {
        Gate::authorize('posts.assign');

        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $target = User::findOrFail($validated['user_id']);
        abort_unless($target->hasRole('user'), 422, 'Posts can only be assigned to users with the User role.');

        $post->assignedUsers()->syncWithoutDetaching([$target->id]);

        return redirect()->route('posts.index')->with('status', 'Post assigned to user.');
    }
}
