<?php
use Slim\Http\Response;
use Slim\Http\Request;
use \Controller\UserController;

$cutPathLog = explode('/rest', __DIR__);
$path = $cutPathLog[0] . '/config/core.php';
require_once($path);

/**
 * Get the list of all user
 * @todo : RESTRICT THIS ROUTE FOR ADMIN
 */
$app->get('/user/list/{token}', function(Request $request, Response $response, array $args){
    $this->logger->addInfo('ws -> test');
    $ctrl = new UserController($this);
    if(validToken($this->get('configToken'), $args['token'], $this)){
        echo json_encode($ctrl->getUserList());
    }else{
        echo json_encode(array("result" => false));
    }
});

/**
 * Add new user in db
 * model body : {name, email, firstname, password, passwordv}
 */
$app->post('/user/add', function(Request $req, Response $res, array $args){
    $ctrl = new UserController($this);
    $params = json_decode($req->getBody(), true);
    $bparamsValid = false;
    $msg = "";
    if($ctrl->isPasswdValid($params['passwd'], $params['passwdv'])){
        if($ctrl->isEmailValid($params['email'])){
            $ctrl->add($params);
            $bparamsValid = true;
        }else{
            $msg = "invalid email";
        }
    }else{
        $msg = "invalid password";
    }
    if(!$bparamsValid){
        return $res->withJson($msg, 400);
    }
});

/**
 * log user if user successfully loged return user
 * model body : {email, passwd}
 */
$app->post('/user/login', function(Request $req, Response $res, array $args){
    $ctrl = new UserController($this);
    $params = json_decode($req->getBody(), true);
    $login = $ctrl->login($params);
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
        $user = $ctrl->getUserByEmail($params['email']);
        $response["token"] = generateToken($this->get('configToken'), $user);
    }
    echo json_encode($response);
});