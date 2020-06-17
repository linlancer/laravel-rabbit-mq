<?php

/**
 * This is an example of queue connection configuration.
 * It will be merged into config/queue.php.
 * You need to set proper values in `.env`.
 */
return [
    'driver' => 'rabbitmq',
    'host' => env('RABBITMQ_HOST', '127.0.0.1'),
    'port' => env('RABBITMQ_PORT', 5672),
    'vhost' => env('RABBITMQ_VHOST', '/'),
    'login' => env('RABBITMQ_LOGIN', 'guest'),
    'password' => env('RABBITMQ_PASSWORD', 'guest')
];
