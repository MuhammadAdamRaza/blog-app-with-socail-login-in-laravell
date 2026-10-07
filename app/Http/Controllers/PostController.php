<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $request->user()->posts()->create([
            'title' => strip_tags($fields['title']),
            'body' => strip_tags($fields['body']),
        ]);

        return redirect()->route('home')->with('status', 'Your post is published.');
    }

    public function update(Request $request, int $post)
    {
        $post = $request->user()->posts()->findOrFail($post);
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post->update([
            'title' => strip_tags($fields['title']),
            'body' => strip_tags($fields['body']),
        ]);

        return redirect()->route('home')->with('status', 'Your post has been updated.');
    }

    public function destroy(Request $request, int $post)
    {
        $request->user()->posts()->findOrFail($post)->delete();

        return redirect()->route('home')->with('status', 'Your post has been deleted.');
    }
}
