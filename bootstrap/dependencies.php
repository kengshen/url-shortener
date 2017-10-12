<?php

$container = $app->getContainer();

$containerConfig = new \Noodlehaus\Config(__DIR__. '/../config');
$container['config'] = function ($c) use ($containerConfig) {
    return $containerConfig;
};

$container['csrf'] = function ($container) {
    $guard = new \Slim\Csrf\Guard;
    $guard->setPersistentTokenMode(true);
    $guard->setFailureCallable(function ($request, $response, $next) {
        $request = $request->withAttribute('csrf_status', false);

        return $next($request, $response);
    });

    return $guard;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false
    ]);
    
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');

    var_dump($basePath);

    die;
    
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

// \Respect\Validation\Validator::with('App\\Validation\\Rules\\');
