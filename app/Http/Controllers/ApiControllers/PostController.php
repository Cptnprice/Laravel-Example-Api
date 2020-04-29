<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Http\Resources\Post as PostResource;
use App\Http\Requests\PostCreate;
use App\Http\Requests\PostUpdate;
use Auth;

class PostController extends Controller
{
    public function index(){
        return PostResource::collection(Post::all());
    }

    public function show($id){
        return new PostResource(Post::findOrFail($id));
    }

    public function store(PostCreate $request){
        $user_id = Auth::user()->id;
        $validated = $request->validated();
        $validated['user_id'] = $user_id;
        $post = Post::create($validated);
        return response([
            'message' => 'Post Created Successfully!',
            'Post' => new PostResource($post)
        ]);
    }

    public function update($id, PostUpdate $request){
        $validated = $request->validated();
        $post = Post::findOrFail($id);
        if (Auth::user()->id != $post->user->id){
            return response(['message' => 'You are not author of this post. You can\'t edit it']);
        }
        else{
            $post->update($validated);
            return response([
                'message' => 'Post has been updated',
                'post' => new PostResource($post)
            ]);
        }
    }

    public function destroy($id, Request $request){
        $post = Post::findOrFail($id);
        if (Auth::user()->id != $post->user->id){
            return response(['message' => 'You are not author of this post. You can\'t delete it']);
        }
        $post->delete();
        return response([
            'message' => 'Post has been deleted'
        ]);
    }
}
