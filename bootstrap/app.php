<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'cache' => false
    ],
]);

require_once __DIR__ . '/dependencies.php';
require_once __DIR__ . '/routes.php';
