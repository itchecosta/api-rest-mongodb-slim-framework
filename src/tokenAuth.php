<?php

namespace src;

use Tuupola\Middleware\JwtAuthentication;

function tokenAuth(): JwtAuthentication
{
    return new JwtAuthentication([
        'secret' => getenv('JWT_SECRET_KEY'),
        'attribute' => 'jwt',
        "error" => function ($response, $arguments) {
            $data = [];
            $data["status"] = "error";
            $data["message"] = "Acesso não autorizado!";

            $body = $response->getBody();
            $body->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

            return $response->withBody($body);
        }
    ]);
}