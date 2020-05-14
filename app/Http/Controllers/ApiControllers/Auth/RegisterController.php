<?php

namespace App\Http\Controllers\ApiControllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterSingleRequest;
use App\User;

class RegisterController extends Controller
{
    public function register(RegisterSingleRequest $request){
        try{
            $request->merge([
                'password' => bcrypt(request('password'))
            ]);
            $user = User::create($request->all());
            $accessToken = $user->createToken('authToken')->accessToken;
            return response(['user' => $user, 'message' => 'User registered successfully']);
        } catch (\Exception $e){
            return response(['message' => 'Something went wrong!', 'errors' => $e->getMessage()]);
        }
    }
}
