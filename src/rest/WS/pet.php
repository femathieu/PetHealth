<?php 

use Slim\Http\Response;
use Slim\Http\Request;

use \Controller\PetController;

/**
 * Add pet
 * model body : { name, birthdate, pet_type_id, user_id }
 */
$app->post('/pet', function(Request $req, Response $res, array $args){
    $ctrl = new PetController($this);
    $params = json_decode($req->getBody(), true);
    if(!validToken($this)){
        return $res->withStatus(401);
    }
    if(!(decodeToken($this)["uuid"] == $params["user_id"])){
        return $res->withStatus(401);
    }
    if($ctrl->add($params)){
        return $res->withStatus(200);
    }else{
        return $res->withStatus(400);
    }
});