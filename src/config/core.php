<?php
use \Firebase\JWT\JWT;
use Controller\UserController;

date_default_timezone_set('Europe/Paris');

/**
 * Generate a jwt token
 */
function generateToken($configToken, $user){
    try{
        if( array_key_exists('uuid', $user) &&
            array_key_exists('firstname', $user) &&
            array_key_exists('name', $user) &&
            array_key_exists('email', $user)
        ){
            $token = array(
                "iss" => $configToken["iss"],
                "aud" => $configToken["aud"],
                "iat" => $configToken["iat"],
                "nbf" => $configToken["nbf"],
                "data" => array(
                    "uuid" => $user["uuid"],
                    "firstname" => $user["firstname"],
                    "lastname" => $user["name"],
                    "email" => $user["email"]
                    )
                );
            $jwt = JWT::encode($token, $configToken['key']);
        }else{
            throw new Exception('generate token : invalid parameters');
        }
    }catch (Exception $e){

    }
    return $jwt;
}

/**
 * return true if given token is valid
 */
function validToken($app){
    $ret = false;
    try {
        $decoded = JWT::decode(getallheaders()['Authorization'], $app->get('configToken')["key"], array('HS256'));
        $ctrl = new UserController($app);
        if(!empty($ctrl->getUserByEmail($decoded->data->email))){
            $ret = true;
        }
    } catch (Exception $e){
        $ret = false;
        $app->logger->addInfo($e->getMessage());
    }
    return $ret;
}

/**
 * decode data of token
 */
function decodeToken($app){
    $ret = array();
    try {
        if(validToken($app)){
            $decoded = JWT::decode(getallheaders()['Authorization'], $app->get('configToken')["key"], array('HS256'));
            $ret = (array)$decoded->data;
        }else{
            throw new Exception('decodeToken : invalid token');
        }
    }catch (Exception $e){
        $ret = array();
        $app->logger->addInfo($e->getMessage());
    }
    return $ret;
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
}