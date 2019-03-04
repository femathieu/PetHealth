<?php
use Slim\Http\Response;
use Slim\Http\Request;

use \Controller\UserController;

$app->get('/test', function(Request $request, Response $response, array $args){
    $ctrl = new UserController();
    // echo json_encode(array("test" => "test"));
    echo json_encode($ctrl->getUserList());
});