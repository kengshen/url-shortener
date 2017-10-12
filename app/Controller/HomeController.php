<?php

class HomeController
{
    public function index($request, $response)
    {
        return $this->container->view->render('home.twig');
    }
}