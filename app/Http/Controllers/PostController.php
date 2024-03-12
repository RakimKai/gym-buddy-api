<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostsResource;
use App\Models\Post;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{

    use HttpResponses;

    public function store(CreatePostRequest $request) {
        $request->validated($request->all());
        $post = Post::create([
            'user_id'=>Auth::user()->id,
            'title'=>$request->title,
            'content'=>$request->content
        ]);

        return $this->success(['post'=>new PostsResource($post)],'Post successfully created',200);
    }
    public function show(Post $post)
    {
        return $this->success(['post'=>new PostsResource($post)],'Post successfully fetched',200);
    }

    public function getAll()
    {
        $posts = Post::all();
        $postsResource = PostsResource::collection($posts);
        return $this->success(['posts'=>($postsResource)],'Posts successfully fetched',200);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return $this->success(['post'=>new PostsResource($post)],'Post successfully modified',200);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return $this->success(null,'Post successfully deleted',200);
    }
}
