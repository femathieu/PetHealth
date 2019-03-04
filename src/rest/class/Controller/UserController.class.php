<?php 

namespace Controller;

use \DAO\UserDao;

class UserController {
    private $name;
    private $dao;

    public function __construct(){
        $this->dao = new UserDao();
    }

    public function getName(){
        return $this->name;
    }

    public function getUserList(){
        return $this->dao->getUserList();
    }
}