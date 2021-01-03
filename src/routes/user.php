<?php

    use src\middlewares\JwtAuth;
    use src\controllers\User;

    $app->group('/user', function () use ($app){

        $app->post('/doSomething', User::class . ":doSomething");
        $app->get('/getInfo', User::class . ":getInfo")->add( new JwtAuth("login") );


    });