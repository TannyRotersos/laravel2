<?php
 use Illuminate\Http\Request;
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

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://127.0.0.1:8001/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://127.0.0.1:8000/oauth/authorize?'.$query);
})->name('api');

Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://127.0.0.1:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '3',
            'client_secret' => 'KML0z1sUQBa95nkFQAxQ3DXJ48WFjjxt7QzyMuG4',
            'redirect_uri' => 'http://127.0.0.1:8001/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});