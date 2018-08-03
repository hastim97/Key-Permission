<?php

use Illuminate\Http\Request;

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

Auth::guard('api')->user(); // instance of the logged user
Auth::guard('api')->check(); // if a user is authenticated
Auth::guard('api')->id(); // the id of the authenticated user

Route::post('register','AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::get('getRole','AuthController@getRole');

Route::post('postPermissionHod','PermissionController@postPermissionHod');
Route::post('postPermissionVp','PermissionController@postPermissionVp');
Route::post('deletePermission','PermissionController@deletePermission');
Route::post('getRooms','RoomController@getRooms');
Route::post('getRoomRequest','RoomController@getRoomRequest');
Route::post('getRoomMonth','RoomController@getRoomMonth');

Route::get('getRooms', 'RoomController@getRooms');
Route::get('getPermissionRoom','RoomController@getPermissionRoom');
Route::get('getPermissionDate','RoomController@getPermissionDate');
Route::get('getPermissionUser','RoomController@getPermissionUser');
Route::get('getPermissionHod','RoomController@getPermissionHod');
Route::get('getPermissionVp','RoomController@getPermissionVp');
Route::get('getAllPermissionHod','RoomController@getAllPermissionHod');
Route::get('getAllPermissionVp','RoomController@getAllPermissionVp');

Route::get('getTry', 'RoomController@getTry');

Route::post('postPermission','PermissionController@postPermission');
