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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login', 'API\Admin\AuthController@login');
Route::post('/register', 'API\Admin\UserController@store');


Route::group(['prefix' => 'admin', 'middleware' => ['auth:user-api', 'scopes:user']], function () {

    Route::post('/logout', 'API\Admin\AuthController@logout');


    Route::apiResource('post', 'API\Admin\PostController');
    Route::apiResource('beat', 'API\Admin\BeatController');

    Route::post('like_post/{id}', 'API\Admin\LikeController@likePost');
    Route::post('like_beat/{id}', 'API\Admin\LikeController@likeBeat');

});
