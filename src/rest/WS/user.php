<?php
use Slim\Http\Response;
use Slim\Http\Request;

use \Controller\UserController;

$app->get('/user/list', function(Request $request, Response $response, array $args){
    $this->logger->addInfo('ws -> test');
    $ctrl = new UserController();
    echo json_encode($ctrl->getUserList());
});