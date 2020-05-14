<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'ApiControllers', 'middleware' => 'auth:api'], function(){
    Route::get('users/', 'UserController@index');
    Route::get('users/{id}', 'UserController@detail');

    Route::get('posts/', 'PostController@index');
    Route::get('posts/{id}', 'PostController@show');
    Route::post('posts/create', 'PostController@store');
    Route::group(["middleware" => "role:editor"], function(){
        Route::post('posts/edit/{id}', 'PostController@update');
        Route::post('posts/delete/{id}', 'PostController@destroy');
    });
});

Route::group(['namespace' => 'ApiControllers\Auth'], function(){
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('logout/', 'LoginController@logoutSingle');
    });
    Route::post('login/single', 'LoginController@loginSingle');
    Route::post('login/company', 'LoginController@loginCompany');
    Route::post('register/single', 'RegisterController@registerSingle');
    Route::post('register/company', 'RegisterController@registerCompany');
});

