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

    /**
     * Retreive a user from his given email
     * @param: $email the email of the user we're searching for
     */
    public function getUserByEmail($email){
        return $this->dao->getUserByEmail($email);
    }

    /**
     * return true if passwd is valid
     * @param: $passwd password
     * @param: $passwdv repeat password
     */
    public function isPasswdValid($passwd, $passwdv){
        $this->app->logger->addInfo('UserController->isPasswdValid');
        $bret = false;
        if($passwd == $passwdv){
            $bret = true;
        }
        return $bret;
    }

    /**
     * return true if $email is valid
     * @param: $email email
     */
    public function isEmailValid($email){
        $this->app->logger->addInfo('UserController->isEmailValid');
        $bret = false;
        if($this->dao->validEmail($email) && empty($this->dao->getUserByEmail($email))){
            $bret = true;
        }
        return $bret;
    }

}