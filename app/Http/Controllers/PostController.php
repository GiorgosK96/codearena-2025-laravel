<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    public function index(?User $user = null)
    {
        $posts = Post::when($user, function ($query) use ($user) {
            return $query->where('user_id', $user->id);
        })
        ->whereNotNull('image')
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
        ->orderByDesc('promoted')
        ->orderByDesc('published_at') 
        ->paginate(9);
    
        $authors = User::whereIn('id', function ($query) {
            $query->select('user_id')
                  ->from('posts')
                  ->whereNotNull('published_at')
                  ->where('published_at', '<=', now())
                  ->distinct();
        })->get();
    
        return view('posts.index', compact('posts', 'authors'));
    }

    public function show(Post $post)
    {
        if ($post->published_at === null) {
            abort(404);
        }

        $post->load(['comments' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);
    
        return view('posts.show', compact('post'));
    }

public function promoted()
{
    $posts = Post::whereNotNull('image')
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
        ->where('promoted', true)
        ->orderByDesc('published_at')
        ->paginate(9);

    $authors = User::whereIn('id', function ($query) {
        $query->select('user_id')
              ->from('posts')
              ->whereNotNull('published_at')
              ->where('published_at', '<=', now())
              ->distinct();
    })->get();

    return view('posts.index', compact('posts', 'authors'));
}
}
