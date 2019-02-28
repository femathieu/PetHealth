<?php
use Slim\Http\Response;
use Slim\Http\Request;

$app->get('/test', function(Request $request, Response $response, array $args){
    echo json_encode(array("test" => "test"));
});