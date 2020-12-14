<?php

namespace src;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FingersCrossedHandler;

function log()
{
    /**
    * Serviço de Logging em Arquivo
    */
    $container['logger'] = function() {
        $logger = new Logger('app-zoox');
        $logfile = __DIR__ . '/logs/app-zoox.log';
        $stream = new StreamHandler($logfile, Logger::DEBUG);
        $fingersCrossed = new FingersCrossedHandler(
            $stream, Logger::INFO);
        $logger->pushHandler($fingersCrossed);
        
        return $logger;
    };
}

