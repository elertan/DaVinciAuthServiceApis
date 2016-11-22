<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use App\Http\Middleware\DaVinciAuthMiddleware;
use App\DaVinciAuthService\DaVinciAuth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/authorized', function (Request $request, DaVinciAuth $auth) {
    return view('authorized', ['user' => $auth->user]);
})->middleware(DaVinciAuthMiddleware::class);

Route::get('/auth/loginCallback', 'AuthController@loginCallback');
