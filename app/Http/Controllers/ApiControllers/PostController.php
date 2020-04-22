<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Http\Resources\Post as PostResource;
use App\Http\Requests\PostCreate;
use App\Http\Requests\PostUpdate;

class PostController extends Controller
{
    public function index(){
        return PostResource::collection(Post::all());
    }

    public function show($id){
        return new PostResource(Post::findOrFail($id));
    }

    public function store(PostCreate $request){
        $validated = $request->validated();
        $post = Post::create($validated);
        return response([
            'message' => 'Post Created Successfully!',
            'Post' => new PostResource($post)
        ]);
    }

    public function update($id, PostUpdate $request){
        $validated = $request->validated();
        $post = Post::findOrFail($id);
        $post->update($validated);
        return response([
            'message' => 'Post has been updated',
            'post' => new PostResource($post)
        ]);
    }

    public function destroy($id){
        $post = Post::findOrFail($id);
        $post->delete();
        return response([
            'message' => 'Post has been deleted'
        ]);
    }
}
