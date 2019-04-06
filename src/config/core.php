<?php
use \Firebase\JWT\JWT;
use Controller\UserController;

date_default_timezone_set('Europe/Paris');

/**
 * Generate a jwt token
 */
function generateToken($configToken, $user){
    $token = array(
        "iss" => $configToken["iss"],
        "aud" => $configToken["aud"],
        "iat" => $configToken["iat"],
        "nbf" => $configToken["nbf"],
        "data" => array(
            "id" => $user["uuid"],
            "firstname" => $user["firstname"],
            "lastname" => $user["name"],
            "email" => $user["email"]
        )
     );
    $jwt = JWT::encode($token, $configToken['key']);
    return $jwt;
}

/**
 * return true if given token is valid
 */
<<<<<<< HEAD
function validToken($configToken, $token, $app){
    $ret = false;
    try {
        $decoded = JWT::decode($token, $configToken["key"], array('HS256'));
=======
function validToken($app){
    $ret = false;
    try {
        $decoded = JWT::decode(getallheaders()['Authorization'], $app->get('configToken')["key"], array('HS256'));
>>>>>>> develop
        $ctrl = new UserController($app);
        if(sizeof($ctrl->getUserByEmail($decoded->data->email)) > 0){
            $ret = true;
        }
    } catch (Exception $e){
        $ret = false;
        $app->logger->addInfo($e->getMessage());
    }
    return $ret;
<<<<<<< HEAD
=======
}

if (!function_exists('getallheaders')) {
    function getallheaders() {
    $headers = [];
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
    }
>>>>>>> develop
}