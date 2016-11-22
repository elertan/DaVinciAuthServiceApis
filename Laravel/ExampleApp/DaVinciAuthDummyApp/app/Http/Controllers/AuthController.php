<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;

class AuthController extends Controller {

    public function loginCallback(Request $request, CookieJar $cookieJar) {
        if ($request->input('err')) {
            // Error has occured with logging in.
            return view('errors/503');
        }
        // Retrieve token from query
        $token = $request->input('token');
        // Queue the token to be put in the response when the view is going to be send
        $cookieJar->queue(cookie('token', $token, 900000));

        // Send the view back to the client
        return view('auth/loginCallback');
    }

}