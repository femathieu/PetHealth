<?php
use Slim\Http\Response;
use Slim\Http\Request;

use \Controller\UserController;

/**
 * Get the list of all user
 * @todo : RESTRICT THIS ROUTE FOR ADMIN
 */
$app->get('/user/list', function(Request $request, Response $response, array $args){
    $this->logger->addInfo('ws -> test');
    $ctrl = new UserController($this);
    echo json_encode($ctrl->getUserList());
});

/**
 * Add new user in db
 * model body : {name, email, firstname, password, passwordv}
 */
$app->post('/user/add', function(Request $req, Response $rep, array $args){
    $ctrl = new UserController($this);
    $params = json_decode($req->getBody(), true);
    $ctrl->add($params);
});