<?php

namespace Dao;

use \PDO;

use \DAO\Db;
use \Dao\UserDao;
use \Dao\PetTypeDao;

class PetDao extends Db {
    private $app;
    private $userDao;
    private $petTypeDao;

    public function __construct($app){
        parent::__construct();
        $this->app = $app;
        $this->userDao = new UserDao($app);
        $this->petTypeDao = new PetTypeDao($app);
    }

    /**
     * add new pet
     * @param: $pet - data of the pet to add
     */
    public function add($pet){
        $this->app->logger->addInfo('PetDao->add');
        $ret = null;
        if($this->validData($pet)){
            $pet['uuid'] = \uniqid();

            $fields = join(array_keys($pet), ',');
            $preparedValues = array();
            foreach($pet as $p){
                $preparedValues[] = '?';
            }
            $preparedValues = join($preparedValues, ',');
            $sql = "INSERT INTO pet ($fields) VALUES ($preparedValues)";
            $query = $this->db()->prepare($sql);
            $ret = $query->execute(array_values($pet));
        }else{
            $ret = false;
        }
        return $ret;
    }

    /**
     * Fetch a pet
     * @param: $uuid - the uuid of the pet to fetch
     */
    public function get($uuid){
        $this->app->logger->addInfo('PetDao->get');
        $quotedUuid = $this->db()->quote($uuid);
        $sql = "SELECT uuid, name, birthdate, pet_type_id, user_id FROM pet WHERE uuid = $quotedUuid";
        $query = $this->db()->query($sql);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Check if the data given are correct for a pet
     * @param: array $pet - contains the data to check
     */
    private function validData($pet){
        $this->app->logger->addInfo('PetDao->validData');
        $ret = null;
        if(
            isset($pet['user_id']) && !empty($pet['user_id']) &&
            isset($pet['birthdate']) && !empty($pet['birthdate']) &&
            isset($pet['name']) && !empty($pet['name']) &&
            isset($pet['pet_type_id']) && !empty($pet['pet_type_id'])
        ){
            if(
                $this->userDao->getUser($pet['user_id']) &&
                $this->petTypeDao->get($pet['pet_type_id']) &&
                preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$pet['birthdate'])
            ){
                $ret = true;
            }else{
                $ret = false;
                $this->app->logger->addInfo("wrong data given");
            }
        }else{
            $ret = false;
            $this->app->logger->addInfo('missing field in $pet');
        }
        return $ret;
    }

    /**
     * Update a pet
     * @param: $pet - data of the pet to update
     * @param: $uuid - uuid of the pet to update
     */
    public function update($pet, $uuid){
        $this->app->logger->addInfo('PetDao->update');
        $ret = null;
        if($this->validData($pet)){
            $uuidQuoted = $this->db()->quote($uuid);
            $sql = "UPDATE pet SET name = :name,
                                   birthdate = :birthdate
                               WHERE uuid = $uuidQuoted
                   ";
            $query = $this->db()->prepare($sql);
            $ret = $query->execute(array(
                ":name" => $pet['name'],
                ":birthdate" => $pet['birthdate']
            ));
        }
        return $ret;
    }

    /**
     * Mark a pet as deleted
     * @param: $uuid - the uuid of the pet to mark as deleted
     */
    public function markAsDelete($uuid){
        $this->app->logger->addInfo('PetDao->MarkAsDelete');
        $ret = null;
        if(!empty($this->get($uuid))){
            $uuidQuoted = $this->db()->quote($uuid);
            $sql = "UPDATE pet SET rec_st = 'D' WHERE uuid = $uuidQuoted";
            $ret = $this->db()->query($sql);
        }
        return $ret;
    }

    /**
     * Delete a pet
     * @param: $uuid - the uuid of the pet to delete 
     */
    public function delete($uuid){
        $this->app->logger->addInfo('PetDao->delete');
        $ret = null;
        if($uuid != null && $uuid != ""){
            $uuidQuoted = $this->db()->quote($uuid);
            $sql = "DELETE FROM pet WHERE uuid = $uuidQuoted";
            $ret = $this->db()->query($sql);
        }
        return $ret;
    }
}