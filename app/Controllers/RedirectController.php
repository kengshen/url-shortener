<?php

namespace App\Controllers;
use App\Library\Alphabet;

class RedirectController extends BaseController
{
    public function index($request, $response, $args)
    {
        if (!isset($args['id'])) {
            return $response->withRedirect($this->container->router->pathFor('home'));
        }
        
        $id = Alphabet::decode($args['id']);

        $filename = __DIR__ . '/../../urls.json';
        $json = file_get_contents($filename);
        $converters = json_decode($json, true);

        if (!isset($converters[$id])) {
            return $response->withRedirect($this->container->router->pathFor('home'));
        }

        // http code 301: changed permenantly
        return $response->withRedirect($converters[$id]['url'], 301);
    }
}