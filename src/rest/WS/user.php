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
$app->get('/user/list/{token}', function(Request $request, Response $response, array $args) use ($app){
    $this->logger->addInfo('ws -> test');
    $ctrl = new UserController($this);
    if(validToken($this)){
        echo json_encode($ctrl->getUserList());
    }else{
        $app->halt(403);
    }
});

/**
 * Add new user in db
 * model body : {name, email, firstname, password, passwordv}
 */
$app->post('/user/add', function(Request $req, Response $res, array $args){
    $ctrl = new UserController($this);
    $params = json_decode($req->getBody(), true);
    echo json_encode(array("result" => $ctrl->add($params)));
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

$app->get('/user/{email}', function(Request $req, Response $res, array $args) use ($app){
    if(validToken($this)){
        $ctrl = new UserController($this);
        echo json_encode($ctrl->getUserByEmail($args['email']));
    }else{
        $app->halt(403);
    }
});