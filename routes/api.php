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

Route::group(['namespace' => 'API'], function () {

    // login route
    Route::post('login', 'AuthController@login');

    // get all users
    Route::get('users', 'UserController@index');

    // show user
    Route::get('show-user', 'UserController@show');

});

// authenticated routes
Route::group(['middleware' => ['jwt.verify:api'], 'namespace' => 'API'], function () {

    // logout route
    Route::post('logout', 'AuthController@logout');

    // show profile
    Route::get('profile', 'UserController@profile');

    // create user route
    Route::post('create-user', 'UserController@store');

    //edit user
    Route::post('edit-user', 'UserController@update');
});
