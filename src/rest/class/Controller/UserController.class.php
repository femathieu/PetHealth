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
    private function getUserByEmail($email){
        return $this->dao->getUserByEmail($email);
    }

    /**
     * return array $user with data of requested user
     * if incorrect id return empty array
     */
    public function login($data){
        $this->app->logger->addInfo('UserController->login');
        $user = array();
        if(isset($data['email']) && isset($data['passwd'])){
            $user = $this->dao->getUserByEmail($data['email']);
            $correctPasswd = false;
            if(sizeof($user) > 0){
                if(\password_verify($data['passwd'], $user['passwd'])){
                    unset($user['passwd']);
                    $correctPasswd = true;
                    //TODO : generate token
                }
            }
        }else{
            $this->app->logger->addInfo('error invalid email or passwd');
        }
        return $user;
    }
}