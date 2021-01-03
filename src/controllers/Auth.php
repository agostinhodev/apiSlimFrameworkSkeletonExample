<?php

namespace src\controllers;

use \Firebase\JWT\JWT;

final class Auth{

    private $exp = NULL;

    public function __set($atrib, $value){
        $this->$atrib = $value;
    }

    public function __get($atrib){
        return $this->$atrib;
    }

    public function generateToken($payload = NULL, $type = NULL){

        if(is_null($payload))
            throw new \Exception("It's necessary to provide a payload in: " . get_class());

        if(is_null($type))
            throw new \Exception("It's necessary to provide a type in: " . get_class());


        switch($type){

            default:
            case "login":

                $jwtkey = getenv('API_JWT_KEY_LOGIN');
                $date = date('Y-m-d H:i:s', strtotime('+1 day', time()));
                $date = strtotime($date);
                $this->__set("exp", $date);

            break;

        }

        if(is_null($this->__get("exp")))
            throw new \Exception("It's necessary to provide a exp to payload");

        $payload['iss'] = "api.techeasy.com.br";
        $payload['exp'] = $this->__get("exp");
        $payload['iat'] = time();
        $payload['aud'] = NULL;

        return JWT::encode($payload, $jwtkey);

    }

}

?>