<?php

namespace App\Http\Controllers\ApiControllers\Auth\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginCompanyRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Company;

class LoginController extends Controller
{
    public function login(LoginCompanyRequest $request){
        $company = Company::where('email', request('email'))->first();
        
        if(!$company){
            return response(['message' => "No such company"]);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::guard('company')->attempt($credentials)) {
            return response(['message' => 'Incorrect password or email']);
        }

        $company = Auth::guard('company')->user();
        $tokenResult = $company->createToken('authToken');
        $token = $tokenResult->token;

        $token->save();
        $data = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
        ];
        return response(['message' => 'Company logged in successfully', 'data' => $data]);
    }

    public function logout(Request $request){
        $company = Auth::guard('company')->user();
        $company->token()->revoke();

        return response()->json([
            'message' => 'Company successfully logged out',
        ]);
    }
}
