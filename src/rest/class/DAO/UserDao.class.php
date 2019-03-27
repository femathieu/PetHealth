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
        if( isset($data['name']) && !empty(['name']) &&
            isset($data['firstname']) && !empty(['firstname']) &&
            isset($data['email']) && !empty(['email']) &&
            isset($data['password']) && !empty(['password']) &&
            isset($data['passwordv']) && !empty(['passwordv'])
        ){
            if($data['password'] == $data['passwordv']){
                if($this->validEmail($data['email'])){
                    $uuidQuoted = $this->db()->quote(\uniqid());
                    $nameQuoted = $this->db()->quote($data['name']);
                    $firstnameQuoted = $this->db()->quote($data['firstname']);
                    $passwordQuoted = $this->db()->quote(password_hash($data['password'], PASSWORD_DEFAULT));
                    $emailQuoted = $this->db()->quote($data['email']);
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
                        ":uuid" => $uuidQuoted,
                        ":name" => $nameQuoted,
                        ":firstname" => $firstnameQuoted,
                        ":email" => $emailQuoted,
                        ":passwd" => $passwordQuoted
                    ));
                }
            }
        }
    }

    /**
     * return boolean
     * Check if the given $email is valid - if it not exists in the db and if it have correct syntax
     * @param: $email - target
     */
    private function validEmail($email){
        $result = array();
        $ret = false;
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailQuoted = $this->db()->quote($email);
            $sql = "SELECT uuid FROM user WHERE email = :email";
            $query = $this->db()->prepare($sql);
            $query->execute(array(
                ':email' => $emailQuoted
            ));
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }
        if($result['uuid'] == null && $result['uuid'] == ""){
            $ret = true;
        }else{
            $this->app->logger->addInfo('user '.$email.' already exists');
        }
        return $ret;
    }
}