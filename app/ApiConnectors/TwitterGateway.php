<?php

namespace App\ApiConnectors;

use Abraham\TwitterOAuth\TwitterOAuth;


class TwitterGateway extends TwitterOAuth
{
    public $connection;

    public function __construct($parameters)
    {
        $this->connection = new TwitterOAuth(
            $parameters[0],
            $parameters[1],
            $parameters[2], 
            $parameters[3]
        );
    }

}