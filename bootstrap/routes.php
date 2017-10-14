<?php

$app->get('/', '\App\Controllers\HomeController:index')->setName('home');
$app->post('/shorten', '\App\Controllers\HomeController:shortenUrl')->setName('home.shorten');

$app->get('/very/short/domain[/{id}]', '\App\Controllers\RedirectController:index')->setName('redirect');