<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use \Firebase\JWT\JWT;
use App\DaVinciAuthService\DaVinciAuth;

class DaVinciAuthMiddleware
{
    protected $auth;

    public function __construct(DaVinciAuth $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->cookie('token')) {
            // This user is not logged in.
            return redirect(env('DAVINCIAUTH_NOT_AUTHORIZED_REDIRECT_URL'));
        }
        // Use the guzzle library to make an api call to check for a valid token
        $client = new Client();
        $url = env('DAVINCIAUTH_VALIDATE_URL') . $request->cookie('token');
        
        $response = $client->get($url);
        $body = $response->getBody();
        $data = json_decode($body);

        if (property_exists($data, 'err')) {
            // An error occured during the validation, user not authorized.
            return redirect(env('DAVINCIAUTH_NOT_AUTHORIZED_REDIRECT_URL'));
        }
        
        $token = $data->token;
        $decoded = JWT::decode($token, env('DAVINCIAUTH_KEY'), ['HS256']);
        // Add the daVinciUser to the $request->get('daVinciUser') method.
        $this->auth->user = $decoded;

        // Add the token in the cookies again with the response
        return $next($request)->withCookie(cookie('token', $token, 900000));
    }

}