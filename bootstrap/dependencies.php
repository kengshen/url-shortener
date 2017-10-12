<?php

$container = $app->getContainer();

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
    $view = new Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);

    $view->addExtension(new Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};

// \Respect\Validation\Validator::with('App\\Validation\\Rules\\');
