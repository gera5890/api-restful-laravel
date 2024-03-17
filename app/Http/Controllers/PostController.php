<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:create posts');
        $this->middleware('can:edit posts');
        $this->middleware('can:delete posts');
    }
    public function index()
    {
        $posts = Post::included()
                ->sort()
                ->filter()
                ->get();

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->validated());
        return response()->json(PostResource::make($post), Response::HTTP_CREATED);
    }

    public function show(Post $post)
    {
        $post = $post->included()->first();
        return response()->json(PostResource::make($post), Response::HTTP_OK);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post = $post->updateOrFail($request->validated());
        return response()->json(PostResource::make($post), Response::HTTP_OK);
    }

    public function destroy(Post $post)
    {
        //
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
