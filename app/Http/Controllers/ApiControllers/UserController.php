<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\User;

class UserController extends Controller
{
    public function index(){
        return UserResource::collection(User::all());
    }

    public function detail($id){
        return new UserResource(User::find($id));
    }
}
