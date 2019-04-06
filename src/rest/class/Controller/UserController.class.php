<?php 

namespace Controller;

use \DAO\UserDao;

class UserController {
    private $dao;
    private $app;
<<<<<<< HEAD
=======
    const INVALID_EMAIL = 1;
    const INVALID_PASSWD = 2;
    const CORRECT_IDS = 3;
    const INVALID_IDS = 4;
>>>>>>> develop

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
<<<<<<< HEAD
=======
        $this->app->logger->addInfo("UserController->add");
>>>>>>> develop
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
<<<<<<< HEAD
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
=======
     * return array $user with data of requested user
     * if incorrect id return empty array
     */
    public function login($data){
        $this->app->logger->addInfo('UserController->login');
        $user = array();
        $ret = null;
        if(isset($data['email']) && isset($data['passwd'])){
            $user = $this->dao->login($data['email']);
            if(sizeof($user) > 0){
                if($user['rec_st'] != 'D'){
                    if(\password_verify($data['passwd'], $user['passwd'])){
                        unset($user['passwd']);
                        $ret = self::CORRECT_IDS;
                        // $user["token"] = generateToken($configToken, $user);
                    }else{
                        $ret = self::INVALID_PASSWD;
                        $this->app->logger->addInfo('user : '.$user['email'].'is deleted');
                    }
                }
            }else{
                $ret = self::INVALID_EMAIL;
            }
        }else{
            $this->app->logger->addInfo('error invalid email or passwd');
            $ret = self::INVALID_IDS;
        }
        return $ret;
>>>>>>> develop
    }

}