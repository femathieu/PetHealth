<?php

namespace Controller;

use \Dao\PetDao;

class PetController {
    private $app;
    private $dao;

    public function __construct($app){
        $this->app = $app;
        $this->dao = new PetDao($app);
    }

    /**
     * add new pet
     * @param: $pet - data of the pet to add
     */
    public function add($pet){
        $this->app->logger->addInfo('PetController->add');
        return $this->dao->add($pet);
    }

    /**
     * Fetch a pet
     * @param: $uuid - the uuid of the pet to fetch
     */
    public function get($uuid){
        $this->app->logger->addInfo('PetController->get');
        return $this->dao->get($uuid);
    }

    /**
     * update a pet
     * @param: $pet - data of the pet to update
     */
    public function update($pet, $uuid){
        $this->app->logger->addInfo('PetController->update');
        return $this->dao->update($pet, $uuid);
    }

    /**
     * mark a pet as deleted
     * @param: $uuid - the uuid of the pet to mark as deleted
     */
    public function markAsDelete($uuid){
        $this->app->logger->addInfo('PetController->MarkAsDelete');
        return $this->dao->markAsDelete($uuid);
    }

    /**
     * delete a pet
     * @param: $uuid - the uuid of the pet to delete 
     */
    public function delete($uuid){
        $this->app->logger->deleteInfo('PetController->add');
        return $this->dao->delete($uuid);
    }
}