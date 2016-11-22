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
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;

Route::get('/loginCallback', function (Request $request, CookieJar $cookieJar, DaVinciAuth $auth) {
	return $auth->login($request, $cookieJar);
});

Route::get('/logout', function (Request $request, CookieJar $cookieJar, DaVinciAuth $auth) {
	$auth->logout($cookieJar);
	return redirect('/');
});

Route::get('/account', function (Request $request, DaVinciAuth $auth) {
	return view('account', ['user' => $auth->user]);
})->middleware(DaVinciAuthMiddleware::class);

Route::get('/', function () {
    return view('welcome');
});
