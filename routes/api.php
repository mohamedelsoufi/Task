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
});

// authenticated routes
Route::group(['middleware' => ['jwt.verify:api'], 'namespace' => 'API'], function () {
    /****** User Routes start *******/
    // logout route
    Route::post('logout', 'AuthController@logout');

    // get all users
    Route::get('users', 'UserController@index');

    // show user
    Route::get('show-user', 'UserController@show');

    // show profile
    Route::get('profile', 'UserController@profile');

    // auth user assignments
    Route::get('myAssignments', 'UserController@myAssignments');

    // create user route
    Route::post('create-user', 'UserController@store');

    //edit user
    Route::post('edit-user', 'UserController@update');

    //delete user
    Route::post('delete-user', 'UserController@delete');
    /******* User Routes start *********/

    /****** Review Routes start *******/
    // get all reviews
    Route::get('reviews', 'ReviewController@index');

    // show review by id
    Route::get('show-review', 'ReviewController@show');

    // create review
    Route::post('create-review', 'ReviewController@store');

    // edit review
    Route::post('edit-review', 'ReviewController@update');

    // add assign
    Route::post('assign-user', 'ReviewController@addAssign');

    // add feedback
    Route::post('add-feedback', 'ReviewController@feedback');
    /****** Review Routes end *******/
});
