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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', 'UserController@listuser');
});
Route::get('/blog', 'BlogController@index');
Route::get('/layout', 'LayoutController@index');
Route::get('/token', 'UserController@get_token');
Route::post('/login', 'UserController@loginpasswordgrant');
Route::get('/blog/details', 'BlogController@blogDetails');
Route::get('/category_list', 'BlogController@category_list');
Route::post('/insert', 'LayoutController@insertLayout');
Route::get('/image', 'ImageController@index');
Route::post('/image', 'ImageController@insertImageWithJsonRequest');
Route::post('/image/update', 'ImageController@updateImage');
Route::get('/invoice', 'InvoiceController@index');
Route::get('/track', 'TrackController@index');
