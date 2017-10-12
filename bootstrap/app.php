<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

(new Dotenv\Dotenv(__DIR__ . '/../config'))->load();

$slimSettings = require __DIR__ . '/settings_slim.php';
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'cache' => false
    ],
]);

require_once __DIR__ . '/dependencies.php';
require_once __DIR__ . '/middlewares.php';
require_once __DIR__ . '/routes.php';
