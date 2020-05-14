<?php

namespace App\Http\Controllers\ApiControllers\Auth\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterCompanyRequest;
use App\Company;

class RegisterController extends Controller
{
    public function register(RegisterCompanyRequest $request){
        try{
            $request->merge([
                'password' => bcrypt(request('password'))
            ]);
            $company = Company::create($request->all());
            $accessToken = $company->createToken('authToken')->accessToken;
            return response(['company' => $company, 'message' => 'Company registered successfully']);
        } catch (\Exception $e){
            return response(['message' => 'Something went wrong!', 'errors' => $e->getMessage()]);
        }
    }
}
