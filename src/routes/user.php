<?php

use src\controllers\User;

    $app->group('/user', function () use ($app){

        $app->post('/doSomething', User::class . ":doSomething");

    });