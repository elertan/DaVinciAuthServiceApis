To use to the api into your project, please copy over all files below in the right folder, if the folders do not exist. Create them yourself in the as shown folder structure.

After that apply these changes.

Add these lines to to the bootstrap/app.php file:

// DaVinciAuth IoC
$app->singleton(
    App\DaVinciAuthService\DaVinciAuth::class,
    App\DaVinciAuthService\DaVinciAuth::class
);

Add these lines to your .env file, these values are unique and should be different on your application!

DAVINCIAUTH_VALIDATE_URL=http://davinciauthservice.nl/Sso/ValidateAuth/cb1e444c-d235-4627-9b75-090efa378800/
DAVINCIAUTH_KEY=mysecretkeyontheauthservice
DAVINCIAUTH_NOT_AUTHORIZED_REDIRECT_URL=/login

And add these lines to the composer.json
"require": {
    "guzzlehttp/guzzle": "~6.0",
    "firebase/php-jwt": "~4.0"
},
(Don’t recreate the require key if it exists already, simply just add the lines inside)

Run composer update to install the missing dependencies

Now to use the api, use the following code as an example.

web.php
<?php

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
