<?php

namespace src\models;

final class User
{
    private $id = NULL;
    private $name = NULL;
    private $password = NULL;

    public function __set($atrib, $value){

        if(!property_exists($this, $atrib))
            throw new \Exception("The attribute " . $atrib . " don't exists in " . get_class());

        $this->$atrib = $value;
    }

    public function __get($atrib){

        if(!property_exists($this, $atrib))
            throw new \Exception("The attribute " . $atrib . " don't exists in " . get_class());

        return $this->$atrib;
    }

}