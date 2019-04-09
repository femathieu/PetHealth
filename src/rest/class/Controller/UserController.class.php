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
     * Retreive a user from his uuid
     * @param: $uuid the uuid of the user we're looking for
     */
    public function getUser($uuid){
        return $this->dao->getUser($uuid);
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

    /**
     * update a user
     * @param: $uuid uuid of user to update
     * @param: $user new data
     */
    public function update($uuid, $user){
        $this->app->logger->addInfo('UserController->update');
        return $this->dao->update($uuid, $user);
    }

    /**
     * mark a user as deleted
     * @param: $uuid - uuid of the user to mark as deleted
     */
    public function markAsDeleted($uuid){
        $this->app->logger->addInfo('UserController->MarkAsDeleted');
        return $this->dao->markAsDeleted($uuid);
    }

    /**
     * delete user
     * @param: $uuid - uuid of the user to delete
     */
    public function delete($uuid){
        $this->app->logger->addInfo('UserController->delete');
        return $this->dao->delete($uuid);
    }
}