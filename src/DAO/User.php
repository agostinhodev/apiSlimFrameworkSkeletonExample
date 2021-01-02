<?php

namespace src\DAO;

use src\models\User as UserModel;

final class User
{

    /** @var $pdo \PDO  */

    private $pdo = NULL;

    public function __construct($pdo = NULL)
    {

        if(!isset($pdo) || is_null($pdo))
            throw new \Exception("PDO it's necessary to mount a connection in class");

        $this->pdo = $pdo->getConnection();

    }

    public function new( UserModel $user)
    {

        $sql = $this->pdo->prepare(
            'INSERT INTO user (name, password) VALUES (:name, :password)'
        );

        $sql->bindValue(':name', $user->__get('name'));
        $sql->bindValue(':password', $user->__get('password'));

        $sql->execute();

        if($sql->rowCount() !== 1)
            throw new \Exception('There was a error when we was trying to create a new user');

    }

}