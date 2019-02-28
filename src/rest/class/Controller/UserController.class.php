<?php 

namespace Controller;

class UserController {
    private $name;

    public function __construct(){
    }

    public function getName(){
        return $this->name;
    }
}