<?php 

namespace DAO;

use \PDO;

abstract class Db {
    const ADDR_DB = "database";
    const PORT_DB = "3306";
    const DB_NAME = "pethealth";
    const USER_NAME = "web";
    const USER_PWD = "capima";
    const OPT = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    private $db;

    public function __construct(){
        try {
            $this->db = new PDO(
                'mysql:host='.self::ADDR_DB.';port:'.self::PORT_DB.';charset=utf8'.';dbname='.self::DB_NAME, 
                self::USER_NAME, 
                self::USER_PWD,
                self::OPT
            );
            // $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    public function getDb(){
        return $this->db;
    }

}