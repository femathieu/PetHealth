<?php

namespace Controller;

use \DAO\UserDao;

class LoginController {
    private $userDao;
    private $app;
    const INVALID_EMAIL = 1;
    const INVALID_PASSWD = 2;
    const CORRECT_IDS = 3;
    const INVALID_IDS = 4;

    public function __construct($app){
        $this->app = $app;
        $this->userDao = new UserDao($app);
    }

    /**
     * return array $user with data of requested user
     * if incorrect id return empty array
     * @param: $email email of logger
     * @param: $passwd password of logger
     */
    public function login($email, $passwd){
        $this->app->logger->addInfo('LoginController->login');
        $user = array();
        $ret = null;
        if($email != "" && $passwd != ""){
            $user = $this->userDao->login($email);
            if($user){
                if($user['rec_st'] != 'D'){
                    if(\password_verify($passwd, $user['passwd'])){
                        unset($user['passwd']);
                        $ret = self::CORRECT_IDS;
                    }else{
                        $ret = self::INVALID_PASSWD;
                    }
                }else{
                    $this->app->logger->addInfo('user : '.$user['email'].'is deleted');
                    $ret = self::INVALID_IDS;
                }
            }else{
                $ret = self::INVALID_EMAIL;
            }
        }else{
            $this->app->logger->addInfo('error invalid email or passwd');
            $ret = self::INVALID_IDS;
        }
        return $ret;
    }
}