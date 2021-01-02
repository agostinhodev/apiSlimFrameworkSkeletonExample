<?php

namespace src\models;

final class User
{
    private $id;
    private $name;
    private $password;

    public function __set($atrib, $value){
        $this->$atrib = $value;
    }

    public function __get($atrib){
        return $this->$atrib;
    }

}