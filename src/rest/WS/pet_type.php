<?php

use Slim\Http\Response;
use Slim\Http\Request;
use \Controller\PetTypeController;

$app->get('/pet/type/list', function(Request $req, Response $res, array $args){
    $ctrl = new PetTypeController($this);
});