<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/viewStudent','ViewController@viewAllRequestsStudent');
Route::get('/viewHOD','ViewController@viewAllRequestsHOD');
Route::get('/viewVP','ViewController@viewAllRequestsVP');
Route::get('/events','ViewController@viewCalendar');
Route::get('/hod','ViewController@viewHOD');
Route::get('/vp','ViewController@viewVP');
Route::get('/get_in','ViewController@login');
Route::get('/create_account','ViewController@register');
Route::get('/forgot_password','ViewController@forgotPassword');

Route::post('login','AuthController@login');
Route::post('register','AuthController@register');
Route::post('logout', 'AuthController@logout');
Route::get('getRole','AuthController@getRole');

Route::get('getRooms','RoomController@getRooms');
Route::get('getPermissionHod','RoomController@getPermissionHod');
Route::get('getPermissionRoom', 'RoomController@getPermissionRoom');
Route::get('getPermissionDate', 'RoomController@getPermissionDate');
Route::get('getPermissionUser','RoomController@getPermissionUser');
Route::get('getPermissionVp','RoomController@getPermissionVp');
Route::get('getAllPermissionHod','RoomController@getAllPermissionHod');
Route::get('getAllPermissionVp','RoomController@getAllPermissionVp');

Route::post('postPermission','PermissionController@postPermission');
Route::post('postPermissionHod','PermissionController@postPermissionHod');
Route::post('postPermissionVp','PermissionController@postPermissionVp');
Route::post('deletePermission','PermissionController@deletePermission');
