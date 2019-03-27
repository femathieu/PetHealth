<?php 

namespace Controller;

use \DAO\UserDao;

class UserController {
    private $dao;
    private $app;

    public function __construct($app){
        $this->app = $app;
        $this->dao = new UserDao($app);
    }

    public function getUserList(){
        return $this->dao->getUserList();
    }

    /**
     * Add a new user in the db
     * @param: $data contains all rows needed for a user
     */
    public function add($data){
        return $this->dao->add($data);
    }
}