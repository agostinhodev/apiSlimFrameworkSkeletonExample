<?php

    require_once "config/env.php";
    require_once "../vendor/autoload.php";

    $app = new Slim\App(

        [

            'settings' =>[

                'displayErrorDetails' => true,

            ],

        ]

    );


    $app->group('/v1', function () use ($app){

        require_once "./routes/user.php";
    });

    $app->run();