<?php

namespace src;

function config(): \Slim\Container
{
    $config = [
        'settings' => [
            'displayErrorDetails' => getenv('DISPLAY_ERRORS_DETAILS'),
        ],
    ];

    $container = new \Slim\Container($config);


    /**
     * Converte os Exceptions entro da Aplicação em respostas JSON
     */
    $container['errorHandler'] = function ($c) {
        return function ($request, $response, $exception) use ($c) {
            $statusCode = $exception->getCode() ? $exception->getCode() : 500;
            return $c['response']->withStatus($statusCode)
                ->withHeader('Content-Type', 'Application/json')
                ->withJson([
                    'error' => \Exception::class,
                    'status' => $statusCode,
                    "message" => $exception->getMessage()
                ], $statusCode);
        };
    };

    /**
    * Converte os Exceptions de Erros 405 - Not Allowed
    */
    $container['notAllowedHandler'] = function ($c) {
        return function ($request, $response, $methods) use ($c) {
            return $c['response']
                ->withStatus(405)
                ->withHeader('Allow', implode(', ', $methods))
                ->withHeader('Content-Type', 'Application/json')
                ->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
                ->withJson([
                    'error' => \Exception::class,
                    'status' => 404,
                    'message' => 'Método não permitido; Método deve ser um de: ' . implode(', ', $methods)
                ], 405);
        };
    };

    /**
     * Converte os Exceptions de Erros 404 - Not Found
     */
    $container['notFoundHandler'] = function ($c) {
        return function ($request, $response) use ($c) {
            return $c['response']
                ->withStatus(404)
                ->withHeader('Content-Type', 'Application/json')
                ->withJson([
                    'error' => \Exception::class,
                    'status' => 404,
                    'message' => 'Página não encontrada'
                ],404);
        };
    };

    $container['logger'] = function($container) {
        $logger = new \Monolog\Logger('app-zoox');
        $logfile = __DIR__ . '/logs/app-zoox.log';
        $stream = new \Monolog\Handler\StreamHandler($logfile, \Monolog\Logger::DEBUG);
        $fingersCrossed = new \Monolog\Handler\FingersCrossedHandler(
            $stream, \Monolog\Logger::INFO);
        $logger->pushHandler($fingersCrossed);
        
        return $logger;
    };

    return $container;
}