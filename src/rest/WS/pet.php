<?php 

use Slim\Http\Response;
use Slim\Http\Request;

use \Controller\PetController;
use Symfony\Component\Validator\Constraints\Uuid;

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

/**
 * Fetch a pet
 * @param: $uuid - the uuid of the pet to fetch
 */
$app->get('/pet/{uuid}', function(Request $req, Response $res, array $args){
    $ctrl = new PetController($this);
    if(!validToken($this)){
        return $res->withStatus(401);
    }
    $pet = $ctrl->get($args['uuid']);
    if(!(decodeToken($this)['uuid'] == $pet['user_id'])){
        return $res->withJson('this pet is not one of yours', 401);
    }
    if(empty($pet)){
        return $res->withStatus(404);
    }
    return $res->withJson($pet, 200);
});

/**
 * update a pet
 * model body : { uuid, name, birthdate, pet_type_id, user_id}
 */
$app->put('/pet/{uuid}', function(Request $req, Response $res, array $args){
    $ctrl = new PetController($this);
    if(!validToken($this)){
        return $res->withStatus(401);
    }
    $params = json_decode($req->getBody(), true);
    if(!(decodeToken($this)['uuid'] == $params['user_id'])){
        return $res->withJson('this pet is not one of yours', 401);
    }
    $pet = $ctrl->get($args['uuid']);
    if(!($args['uuid'] == $params['uuid']) && empty($pet)){
        return $res->withStatus(400);
    }
    if($ctrl->update($params, $args['uuid'])){
        return $res->withStatus(200);
    }else{
        return $res->withStatus(400);
    }
});

/**
 * Mark a pet as delete
 * @param: uuid - the uuid of the pet to mark as deleted
 */
$app->put('/pet/delete/{uuid}', function(Request $req, Response $res, array $args){
    $ctrl = new PetController($this);
    if(!validToken($this)){
        return $res->withStatus(401);
    }
    $pet = $ctrl->get($args['uuid']);
    if(empty($pet)){
        return $res->withStatus(404);
    }
    if(!(decodeToken($this)['uuid'] == $pet['user_id']) && decodeToken($this)['role'] != 'admin'){
        return $res->withStatus(401);
    }
    return $ctrl->markAsDelete($args['uuid']);
});

/** 
 * Delete pet
 * @param: uuid - the uuid of pet to delete
*/
$app->delete('/pet/{uuid}', function(Request $req, Response $res, array $args){
    $ctrl = new PetController($this);
    if(!validToken($this)){
        return $res->withStatus(401);
    }
    $pet = $ctrl->get($args['uuid']);
    if(empty($pet)){
        return $res->withStatus(404);
    }
    if(decodeToken($this)['role'] != 'admin'){
        return $res->withStatus(401);
    }
    return $ctrl->delete($args['uuid']);

});