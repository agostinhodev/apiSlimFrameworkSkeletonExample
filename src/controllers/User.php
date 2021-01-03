<?php

//Namespace
namespace src\controllers;

//Request & Response
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Model
use src\models\User as UserModel;


//DAO
use src\DAO\User as UserDAO;

//Database
use src\database\Database;

class User
{

    private $httpStatusCode = 406;
    private $response = array();

    /** @var $pdo Database */
    private $pdo = NULL;

    private function mountConnectionDatabase()
    {
        $this->pdo = new Database();
    }

    public function doSomething(Request $request, Response $response, array $args): Response
    {

        try {

            //$this->mountConnectionDatabase();
            //$this->pdo->beginTransaction();

            $user = new UserModel();
            $user->__set('id', 1);
            $user->__set('name', 'Arthur Martins Prates');
            $user->__set('password', '7896784567');

            $payload = [

                'sub' => $user->__get('id'),
                'name' => $user->__get('name')

            ];

            $auth = new Auth();
            $token = $auth->generateToken( $payload, "login" );

            /*$userDAO = new UserDAO( $this->pdo );
            $userDAO->new( $user );*/

            $this->response['token'] = $token;
            $this->httpStatusCode = 200;

            //$this->pdo->commit();

        }catch (\PDOException $pdoE){

            $this->response['message'] = "Code " . $pdoE->getCode() . " | Info:" . $pdoE->getMessage();


        }catch(\Exception $e){

            if($this->pdo Instanceof \PDO)
                $this->pdo->rollBack();

            $this->response['message'] = $e->getMessage();

        }

        return $response
            ->withJSON($this->response)
            ->withStatus($this->httpStatusCode);

    }

}