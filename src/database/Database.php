<?php

namespace src\database;

class Database{

    private $pdo = NULL;
    private $hostname = NULL;
    private $database = NULL;
    private $port     = NULL;
    private $username = NULL;
    private $password = NULL;

    public function __construct(){

        if(is_null($this->pdo)){

            $this->validateParams();

            $dsn = "mysql:host={$this->hostname};dbname={$this->database};port={$this->port}";

            $this->pdo = new \PDO($dsn, $this->username, $this->password);

            $this->pdo->setAttribute(

                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION

            );

            $this->pdo->setAttribute(\PDO::ATTR_AUTOCOMMIT,0);

        }

    }

    private function validateParams(){

        $hostname = getenv('API_DB_HOSTNAME');
        $database = getenv('API_DB_DATABASE');
        $port     = getenv('API_DB_PORT');
        $username = getenv('API_DB_USERNAME');
        $password = getenv('API_DB_PASSWORD');

        if(!$hostname)
            throw new \Exception("It's necessary to provide a HOSTNAME for connection");

        if(!$database)
            throw new \Exception("It's necessary to provide a DATABASE for connection");

        if(!$port)
            throw new \Exception("It's necessary to provide a PORT for connection");

        if(!$username)
            throw new \Exception("It's necessary to provide a USERNAME for connection");

        if(!$password)
            throw new \Exception("It's necessary to provide a PASSWORD for connection");

        $this->hostname = $hostname;
        $this->database = $database;
        $this->port     = $port;
        $this->username = $username;
        $this->password = $password;

    }

    public function getConnection(){

        return $this->pdo;

    }

    public function beginTransaction(){

        if(!$this->pdo->inTransaction())
            $this->pdo->beginTransaction();

    }

    public function rollBack(){

        if($this->pdo->inTransaction())
            $this->pdo->rollBack();

    }

    public function commit(){

        if($this->pdo->inTransaction())
            $this->pdo->commit();

    }

}