<?php
namespace DAO;

use \DAO\Db;
use \PDO;

class UserDao extends Db {
    private $db;

    public function __construct(){
        parent::__construct();
        $this->db = parent::getDb();
    }

    public function getUserList(){
        $sql = "SELECT id, label FROM test";
        $query = $this->db->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}