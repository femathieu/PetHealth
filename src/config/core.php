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
function validToken($configToken, $token, $app){
    $ret = false;
    try {
        $decoded = JWT::decode($token, $configToken["key"], array('HS256'));
        $ctrl = new UserController($app);
        if(sizeof($ctrl->getUserByEmail($decoded->data->email)) > 0){
            $ret = true;
        }
    } catch (Exception $e){
        $ret = false;
        $app->logger->addInfo($e->getMessage());
    }
    return $ret;
}