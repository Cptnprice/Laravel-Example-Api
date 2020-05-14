<?php

namespace App\Http\Controllers\ApiControllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginSingleRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;

class LoginController extends Controller
{
    public function loginSingle(LoginSingleRequest $request){
        $user = User::where('email', request('email'))->first();
        
        if(!$user){
            return response(['message' => "No such user"]);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response(['message' => 'Incorrect password or email']);
        }

        $user = auth()->user();
        $tokenResult = $user->createToken('authToken');
        $token = $tokenResult->token;

        $token->save();
        $data = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
        ];
        return response(['message' => 'User logged in successfully', 'data' => $data]);
    }

    public function logoutSingle(Request $request){
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
