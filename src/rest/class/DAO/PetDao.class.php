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
                $this->app->logger->addInfo("wrong data given");
            }
        }else{
            $this->app->logger->addInfo('missing field in $pet');
        }
        return $ret;
    }
}