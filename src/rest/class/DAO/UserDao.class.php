<?php
namespace DAO;

use \DAO\Db;
use \PDO;

class UserDao extends Db {
    private $app;

    public function __construct($app){
        parent::__construct();
        $this->app = $app;
    }

    public function getUserList(){
        $sql = "SELECT uuid, name, firstname, email FROM user";
        $query = $this->db()->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Persist $data in the db
     * @param: $data contains all detail of the user to add
     */
    public function add($data){
        $this->app->logger->addInfo('UserDao->add');
        if( isset($data['name']) && !empty(['name']) &&
            isset($data['firstname']) && !empty(['firstname']) &&
            isset($data['email']) && !empty(['email']) &&
            isset($data['passwd']) && !empty(['passwd']) && 
            isset($data['passwdv']) && !empty(['passwdv'])
        ){
            if($data['passwd'] == $data['passwdv']){
                if($this->validEmail($data['email']) && empty($this->getUserByEmail($data['email']))){
                    $sql = "INSERT INTO user ( uuid, 
                                               name, 
                                               firstname, 
                                               email,
                                               passwd,
                                               rec_st)
                                        VALUES ( :uuid,
                                                 :name,
                                                 :firstname,
                                                 :email,
                                                 :passwd,
                                                 'C'
                                                )";
                    $query = $this->db()->prepare($sql);
                    $query->execute(array(
                        ":uuid" => \uniqid(),
                        ":name" => $data['name'],
                        ":firstname" => $data['firstname'],
                        ":email" => $data['email'],
                        ":passwd" => password_hash($data['passwd'], PASSWORD_BCRYPT)
                    ));
                }
            }else{
                $this->app->logger->addInfo('password doesn\'t match');
            }
        }else{
            $this->app->logger->addInfo('missing field in $data');
        }
    }

    /**
     * return boolean
     * Check if the given $email is valid - if it exists in the db and if it have correct syntax
     * @param: $email - target
     */
    public function validEmail($email){
        $ret = false;
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $ret = true;
        }
        return $ret;
    }

    /**
     * Retreive a user from his given email
     * @param: $email the email of the user we're searching for
     * return empty array if no user found
     */
    public function getUserByEmail($email){
        $this->app->logger->addInfo('UserDao->getUserByEmail');
        $result = array();
        if($this->validEmail($email)){
            $emailQuoted = $this->db()->quote($email);
            $sql = "SELECT uuid, name, firstname, email, rec_st FROM user WHERE email = $emailQuoted AND rec_st != 'D'";
            $query = $this->db()->query($sql);
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }else{
            $this->app->logger->addInfo("email : $email is not valid");
        }
        
        return $result;
    }

    /**
     * Retreive all data of user from his given email
     * @param: $email the email of the user we're searching for
     * return empty array if no user found
     */
    public function login($email){
        $this->app->logger->addInfo('UserDao->getUserByEmail');
        $result = array();
        
        $emailQuoted = $this->db()->quote($email);
        $sql = "SELECT uuid, name, firstname, email, passwd, rec_st FROM user WHERE email = $emailQuoted AND rec_st != 'D'";
        $query = $this->db()->query($sql);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    /**
     * Retreive user from his uuid
     * @param: $uuid the uuid of the user we're looking for
     * return null array if no user found
     */
    public function getUser($uuid){
        $this->app->logger->addInfo('UserDao->getUser');
        $result = array();
        $quotedUuid = $this->db()->quote($uuid);
        $sql = "SELECT uuid, firstname, name, email, rec_st, role FROM user WHERE uuid=$quotedUuid AND rec_st != 'D'";
        $query = $this->db()->query($sql);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * update a user
     * @param: $uuid uuid of the user to update
     * @param: $user new data
     */
    public function update($uuid, $user){
        $this->app->logger->addInfo('UserDao->update'.$user['uuid']);
        $quotedUuid = $this->db()->quote($uuid);
        $ret = false;

        $sql = "UPDATE user SET 
                                name = ?,
                                firstname = ?,
                                email = ?,
                                passwd = ?,
                                rec_st = ?
                WHERE uuid = $quotedUuid
        ";
        
        $isEmailValid = false;
        ///Check if email syntax is ok
        if($this->validEmail($user['email'])){
            $u = $this->getUserByEmail($user['email']);
            ///If user found for given email
            if(!empty($u)){
                ///If email already exists check if the uuid match
                ///if it does it means the user is trying to update his profile
                if($u['uuid'] == $user['uuid']){
                    $isEmailValid = true;
                }else{
                    $isEmailValid = false;
                    $this->app->logger->addInfo('invalid email');
                }
            }else{
                $isEmailValid = true;
            }
            if(($user['passwd'] == $user['passwdv']) && $isEmailValid){
                unset($user['passwdv']);
                unset($user['uuid']);
                $user['passwd'] = password_hash($user['passwd'], PASSWORD_BCRYPT);
                $user['rec_st'] = 'U';
                
                $query = $this->db()->prepare($sql);
                $ret = $query->execute(array_values($user));
            }{
                $this->app->logger->addInfo('invalid passwd');
            }
        }else{
            $this->app->logger->addInfo('invalid email');
        }
        
        return $ret;
    }
}