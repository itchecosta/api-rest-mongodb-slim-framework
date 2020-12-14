<?php

namespace App\DAO;

use \MongoDB\Client as Mongo;

abstract class Conexao
{
    protected $client;

    public function __construct()
    {
        
        try {
            $this->client = new Mongo(getenv("MONGO_URL"));
            
        } catch (\Throwable $th) {
            echo $th->getMessage();
			echo nl2br("n");
        }

    }

}