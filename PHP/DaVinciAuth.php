<?php
use \Firebase\JWT\JWT;
class DaVinciAuth {

    public static $user;

    public static function ensureLoggedIn() {
        $config = require("config.php");
        require_once 'Requests/library/Requests.php';
        require_once 'php-jwt/src/JWT.php';
        Requests::register_autoloader();
        if (!isset($_COOKIE["DaVinciAuthToken"])) {
            header('Location: ' . $config["DAVINCIAUTH_NOT_AUTHORIZED_REDIRECT_URL"]);
            die();
        }
        $url = $config["DAVINCIAUTH_VALIDATE_URL"] . $_COOKIE["DaVinciAuthToken"];
        $response = Requests::get($url);
        $data = json_decode($response->body);
        if (isset($data->err)) {
            header('Location: ' . $config["DAVINCIAUTH_NOT_AUTHORIZED_REDIRECT_URL"]);
            die();
        }
        setcookie("DaVinciAuthToken", $data->token);
        $token = $data->token;
        self::$user = JWT::decode($token, $config['DAVINCIAUTH_KEY'], ['HS256']);
    }

    public static function login() {
        parse_str($_SERVER["QUERY_STRING"], $query);
        $token = $query["token"];
        setcookie("DaVinciAuthToken", $token);
        if (isset($query["returnUrl"])) {
            echo "<script>window.opener.location.href = '" . $query["returnUrl"] . "';window.close();</script>";
        } else {
            echo "<script>window.opener.location.href = '/';window.close();</script>";
        }
    }

    public static function logout() {
        setcookie("DaVinciAuthToken", "");
        header('Location: /');
        die();
    }

}