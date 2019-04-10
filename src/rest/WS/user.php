<?php
use Slim\Http\Response;
use Slim\Http\Request;
use \Controller\UserController;

/**
 * Get the list of all user
 * @todo : RESTRICT THIS ROUTE FOR ADMIN
 */
$app->get('/user/{email}/{uuid}', function(Request $request, Response $response, array $args){
    $this->logger->addInfo('ws -> test');
    $ctrl = new UserController($this);
    $ret = array();
    if(validToken($this)){
        if($args['email'] == 'all' && $args['uuid'] == 'all'){
            $ret =$ctrl->getUserList();
        }
        echo json_encode($ret);
    }else{
        return $response->withStatus(401);
    }
});

/**
 * Add new user in db
 * model body : {name, email, firstname, passwd, passwdv}
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
 * update a user with the given user
 * model body : {name, email, firstname, passwd, passwdv, rec_st}
 */
$app->put('/user/{uuid}', function(Request $req, Response $res, array $args){
    $userCtrl = new UserController($this);
    $params = json_decode($req->getBody(), true);
    if(validToken($this)){
        if(decodeToken($this)['uuid'] == $args['uuid']){
            if(!empty($userCtrl->getUser($args['uuid']))){
                $params['uuid'] = $args['uuid'];
                $ret = $userCtrl->update($args['uuid'], $params);
                if($ret){
                    return $res->withJson(generateToken($this->get('configToken'), $userCtrl->getUser($args['uuid'])), 200);
                }else{
                    return $res->withStatus(400);
                }
            }else{
                return $res->withJson("no user found for id :".$args['uuid'], 400);
            }
        }else{
            return $res->withJson("id doesn't match", 401);
        }
    }else{
        return $res->withStatus(401);
    }
});