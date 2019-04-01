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
                if(!$this->validEmail($data['email'])){
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
    private function validEmail($email){
        $result = array();
        $ret = false;
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = "SELECT uuid FROM user WHERE email = :email";
            $query = $this->db()->prepare($sql);
            $query->execute(array(
                ':email' => $email
            ));
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }
        if(isset($result['uuid'])){
            $ret = true;
        }else{
            $this->app->logger->addInfo('user '.$email.' does not exists');
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
            $sql = "SELECT uuid, name, firstname, email, passwd, rec_st FROM user WHERE email = $emailQuoted";
            $query = $this->db()->query($sql);
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }else{
            $this->app->logger->addInfo("email : $email is invalid");
        }
        
        return $result;
    }
}