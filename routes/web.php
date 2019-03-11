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
        'redirect_uri' => 'http://127.0.0.1:8002/callback',
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
            'client_secret' => 'IqNvSZSyoYvZyrfYpkRtJmlqlUm82df1okscsHcz',
            'redirect_uri' => 'http://127.0.0.1:8002/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

Route::get('/todos', function(){
    $http = new GuzzleHttp\Client;

$response = $http->get('http://127.0.0.1:8000/api/todos', [
        'form_params' => [
            'accept'=> 'application/json',
            'authorization'=>'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjQ2ZDFlMGU4ZGY1YWI1MDEyMjc0NDljYjc3OTRjODM4ZjY1Nzg4MzQxZDNjYWNjODY3MTM5ZDg0NmNlY2E0ZDRmZjU2Y2QyZDMyN2FjNzI5In0.eyJhdWQiOiIzIiwianRpIjoiNDZkMWUwZThkZjVhYjUwMTIyNzQ0OWNiNzc5NGM4MzhmNjU3ODgzNDFkM2NhY2M4NjcxMzlkODQ2Y2VjYTRkNGZmNTZjZDJkMzI3YWM3MjkiLCJpYXQiOjE1NTIyNjc5NzgsIm5iZiI6MTU1MjI2Nzk3OCwiZXhwIjoxNTgzODkwMzc4LCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.QybOydIHud3v58aP3ElI0vvhf-gbkuU4UAkYL16bB9-cKY51jvqC5piz5QNIAK64yBkVn6ERa6bFcAFk3GbHGef3z9OcJ7z-Mhe0vuO7wRRFK5sFCOimGFOFjxlN0sgXbAIvpXNWuataTal7HW8F774nYqTftsFLFPAvo9tExOottyxhqjzz8R9m6V3vdVl4HX-5djS2FwOewdlpHx-diZQPixR7Q93eFJ00lhtV2Uz6gsy84M2KGVkhlm6fujsjZhWh9_gomHNO71Y1QUwIvCUZLtIUAf54W0C9xzsG5f7M7r2M4naIvhni-95U8Ee3gX6RIm5mvsn-yrfYWwcDcVp7NllAr72uQgJ5qFij5P7Zjq42pT3yGXGVzHfEVPzs4p2wPBr9mV3SXuejT7USrUpKcMwqZqVdJOQA9VnXmSbdqZZt2iVCj8pxgWCa4LZ2_bx5EMvkgZyYPoy3rjQsLMkx86Kgqhxcu0P0o-eNVAbtdb7V3RBBXxlfVVMjGD1EaZrwyyIX5D2f4RgFI4fWfa5d7V_OdHcpY1l1-cW3hN5bswEPxSUJFWKWFACoFD4UwuZ5dinhtWUbIgWYPr8SQIbH4S6zgtHFN-zpWBxFg1jt7PxVCZyyJaPgbnsc4oYEvupuWXNXGNbUCa2bbMxAEoYuGXDtRLd2b3s6n0cbKdg'
        ],
    ]);
        
   // dd(json_decode((string) $response->getBody(), true));
     $todos=json_decode((string) $response->getBody(), true);
    return view('todos', ['todos'=>$todos]);

})->name('view.todos');

