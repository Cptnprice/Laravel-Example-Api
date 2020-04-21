<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    public function index(){
        return PostResource::collection(Post::all());
    }

    public function detail($id){
        return new PostResource(Post::find($id));
    }
}
