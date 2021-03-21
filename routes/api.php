<?php

use App\Http\Middleware\ConfirmedMiddleware;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Middleware\SignupMiddleware;
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

Route::post('/user/signup', 'UserController@signup')->middleware(SignupMiddleware::class);
Route::post('/user/login', 'UserController@login')->middleware(LoginMiddleware::class);
Route::group(['middleware' => 'auth:sanctum'], function () {
    // Private API for Admin , Users Section
    Route::get('/user', 'UserController@listuser');
    Route::get('/user/check', 'UserController@checkConfirm');
    Route::get('/user/detail', 'UserController@user_detail');
    Route::get('/user/logout', 'UserController@logout');
    Route::put('/user/confirmed', 'UserController@confirmed')->middleware(ConfirmedMiddleware::class);
    Route::put('/user/update/{name}', 'UserController@update');

    // Private API for Metode Pembayaran
    Route::get('/metode-pembayaran', 'MetodePembayaranController@index');

    // Private API for Status Pembayaran
    Route::get('/status-pembayaran', 'StatusPembayaranController@index');

    // Private API for Customers
    Route::get("/customers", 'CustomerController@getAllCustomers');

    // Private API for Kurir
    Route::get('/kurir', 'KurirController@index');

    // Private API for Invoice
    Route::post('/invoice', 'InvoiceController@insertInvoice');
});
// Public API for Client 
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
// Route::get('/start', '');
