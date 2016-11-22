<?php namespace App\DaVinciAuthService;

use \Illuminate\Http\Request;
use \Illuminate\Cookie\CookieJar;

class DaVinciAuth {

    public $user;

    public function login(Request $request, CookieJar $cookieJar) {
        if ($request->input('err')) {
            // Error has occured with logging in.
            dd($request->input('err'));
        }
        // Retrieve token from query
        $token = $request->input('token');
        // Queue the token to be put in the response when the view is going to be send
        $cookieJar->queue(cookie('DaVinciAuthToken', $token, 315360000));

        // Send the view back to the client
        if ($request->input('returnUrl')) {
            return "<script>window.opener.location.href = '" . $request->input('returnUrl') . "';window.close();</script>";
        } else {
            return "<script>window.opener.location.href = '/';window.close();</script>";
        }
    }

    public function logout(CookieJar $cookieJar) {
        $cookieJar->queue(cookie('DaVinciAuthToken', '', 315360000));
    }
}