<?php

use src\controllers\User;

    $app->group('/user', function () use ($app){

        $app->get('/doSomething', User::class . ":doSomething");

    });