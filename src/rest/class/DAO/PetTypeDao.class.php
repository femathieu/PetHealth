<?php

namespace Dao;

use \Dao\Db;

use \PDO;

class PetTypeDao extends Db {
    private $app;

    public function __construct($app){
        parent::__construct();
        $this->app = $app;
    }

    public function get($uuid){
        $this->app->logger->addInfo('PetTypeDao->get');
        $uuidQuoted = $this->db()->quote($uuid);
        $sql = "SELECT uuid, label, rec_st FROM pet_type WHERE uuid = $uuidQuoted";
        $query = $this->db()->query($sql);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}