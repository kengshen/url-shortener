<?php

namespace App\Controllers;
use Curl\Curl;
use App\Library\Alphabet;

class HomeController extends BaseController
{
    public function index($request, $response)
    {
        return $this->container->view->render($response, 'home.twig');
    }

    public function shortenUrl($request, $response)
    {
        if (!$request->getParam('url')) {
            return $response->withJson([
                'error' => 'Url not found'
            ]);
        }

        if (!preg_match('/[a-zA-Z0-9]+[.][a-zA-Z0-9]+/', $request->getParam('url'))) {
            return $response->withJson([
                'error' => 'Not a valid Url'
            ]);
        }

        $url = 'http://' . $request->getParam('url');

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return $response->withJson([
                'error' => 'Not a valid Url'
            ]);
        }

        $maxId = 0;
        $filename = __DIR__ . '/../../urls.json';
        
        if (file_exists($filename)) {

            $json = file_get_contents($filename);
            $converters = json_decode($json, true);

            if (!json_last_error() ) {

                if (!is_null($converters)) {
                    // loop through all the urls to find 
                    foreach ($converters as $converter) {
                        if ($url === $converter['url']) {
                            return $response->withJson([
                                'success' => 1,
                                'shortenedUrl' => $converter['shortenedUrl'],
                            ]);
                        }
                    }

                    ksort($converters);
                    
                    end($converters);

                    $maxId = key($converters);

                    reset($converters);
                }
            }
        }
        
        $redirectedUrl = $request->getUri()->getScheme()
        . '://'
        . $request->getUri()->getHost()
        . ':'
        . $request->getUri()->getPort()
        . $this->container->router->pathFor('redirect')
        . '/'
        . Alphabet::encode($maxId + 1);

        $converters[($maxId + 1)] = [
            'url' => $url,
            'shortenedUrl' => $redirectedUrl
        ];

        file_put_contents($filename, json_encode($converters, JSON_PRETTY_PRINT));

        return $response->withJson([
            'success' => 1,
            'shortenedUrl' => $redirectedUrl,
        ]);
    }
}