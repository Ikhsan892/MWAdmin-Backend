<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/redirect', function (Request $request) {
    //$request->session()->put('state', $state = Str::random(40));

    $query = http_build_query([
        'client_id' => '4',
        'redirect_uri' => 'http://localhost:8000/callback',
        'response_type' => 'code',
        'scope' => '',
        'state' => \Str::random(40)
    ]);

    return redirect('http://localhost:8000/oauth/authorize?' . $query);
});
Route::get('/callback', function (Request $request) {
    // $state = $request->session()->pull('state');

    // throw_unless(
    //     strlen($state) > 0 && $state === $request->state,
    //     InvalidArgumentException::class
    // );

    $http = new GuzzleHttp\Client;

    $response = $http->post('http://localhost:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '4',
            'client_secret' => '4PAlXkl2sypZU9heGNs2PmeEJwrgik132yKgzHAa',
            'redirect_uri' => 'http://localhost:8000/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});
