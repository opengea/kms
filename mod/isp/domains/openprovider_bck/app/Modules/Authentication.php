<?php

namespace App\Modules;

use App\Api\OP_API;

class Authentication
{

    private $api;

    public function setApi(){

        global $cfg;
        $this->api = new OP_API($cfg['api']);
        //$this->api->setDebug(1);

        return $this->api;

    }

}