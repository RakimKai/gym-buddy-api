<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostsResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\table;

class PostController extends Controller
{

     public function store(CreatePostRequest $request) {
        $request->validated($request->all());
        $post = Post::create([
            'user_id'=>Auth::user()->id,
            'title'=>$request->title,
            'content'=>$request->content
        ]);

        return new PostsResource($post);
    }
    public function show(Post $post)
    {
        return new PostsResource($post);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return new PostsResource($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response(null,204);
    }
}
