<?php
use Slim\Http\Response;
use Slim\Http\Request;
use \Controller\LoginController;
use Controller\UserController;

/**
 * log user if user successfully loged return user
 * model body : {email, passwd}
 */
$app->post('/login', function(Request $req, Response $res, array $args){
    $ctrl = new LoginController($this);
    $userCtrl = new UserController($this);
    $params = json_decode($req->getBody(), true);
    $login = $ctrl->login($params['email'], $params['passwd']);
    $result = false;
    $msg = null;
    if($login == $ctrl::CORRECT_IDS){
        $result = true;
    }else{
        $result = false;
        switch($login){
            case $ctrl::INVALID_IDS:
                $msg = "missing email or passwd";
                break;
            case $ctrl::INVALID_EMAIL:
                $msg = "incorrect email";
                break;
            case $ctrl::INVALID_PASSWD:
                $msg = "incorrect passwd";
                break;
        }
    }
    $response = array("result" => $result, "msg" => $msg);
    if($result){
        $user = $userCtrl->getUserByEmail($params['email']);
        $response["token"] = generateToken($this->get('configToken'), $user);
        $response["user"] = $user;
        echo json_encode($response);
    }else{
        return $res->withJson($response, 400);
    }
});