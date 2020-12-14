<?php

namespace src;

use Tuupola\Middleware\HttpBasicAuthentication;

function basicAuth(): HttpBasicAuthentication
{
    return new HttpBasicAuthentication([
        "users" => [
            "root" => "zoox2020"
        ],
        "error" => function ($response, $arguments) {
            $data = [];
            $data["status"] = "error";
            $data["message"] = "Acesso não autorizado!";
    
            $body = $response->getBody();
            $body->write(json_encode($data, JSON_UNESCAPED_SLASHES));
    
            return $response->withBody($body);
        }
    ]);
}