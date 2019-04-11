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
}