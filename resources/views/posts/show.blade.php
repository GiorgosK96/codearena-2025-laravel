@extends('layouts.app')

@section('content')
<div class="bg-white px-6 py-32 lg:px-8">
    <div class="mx-auto max-w-3xl text-base/7 text-gray-700">
      <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl">{{ $post->title }}</h1>
      <p class="mt-6 text-xl/8">{{ $post->description }}</p>
      <img class="aspect-video rounded-xl bg-gray-50 object-cover mt-10" src="{{ $post->image }}" alt="{{ $post->title }}">
      <div class="mt-16 max-w-2xl">
        <p class="mt-6">{{ $post->body }}</p>
      </div>
      <div class="mt-16 font-bold">
        <a href="">{{ $post->author->name }}</a>
      </div>

      <div class="mt-16">
  <h2 class="text-2xl font-semibold mb-4">Comments</h2>
  
  @if($post->comments->count() > 0)
    <div class="space-y-6">
      @php
        // Ταξινομούμε τα σχόλια κατά φθίνουσα σειρά ημερομηνίας δημιουργίας
        $sortedComments = $post->comments->sortByDesc('created_at');
      @endphp
      
      @foreach($sortedComments as $comment)
        <div class="p-4 border rounded-lg">
          <div class="flex justify-between items-center">
            <div class="font-semibold">{{ $comment->name }}</div>
            <form action="{{ route('comment.delete', $comment) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
            </form>
          </div>
          <p class="mt-2">{{ $comment->body }}</p>
          <div class="mt-2 text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</div>
        </div>
      @endforeach
    </div>
  @else
    <p class="text-gray-500">No comments yet.</p>
  @endif
</div>

      <div class="mt-16">
        <h2 class="text-2xl font-semibold mb-4">Leave a Comment</h2>
        <form id="comment-form" action="{{ route('comment', $post) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" required name="name" class="w-full px-3 py-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="body" class="block text-gray-700">Comment</label>
                <textarea id="body" required name="body" class="w-full px-3 py-2 border rounded-md" rows="4"></textarea>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Submit</button>
        </form>
      </div>
    </div>
  </div>
@endsection