<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required',
            'body' => 'required',
        ]);

        $post->comments()->create([
            'name' => $request->name,
            'body' => $request->body,
        ]);

        return redirect()->route('post', $post)->with('success', 'Comment added successfully!');
    }
public function destroy(Comment $comment)
{
    $post = $comment->post;
    $comment->delete();

    return redirect()->route('post', $post)->with('success', 'Comment deleted successfully!');
}
}