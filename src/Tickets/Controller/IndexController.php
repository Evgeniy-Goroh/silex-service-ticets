<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
    public function indexAction(Request $request, Application $app)
    {
        $data = array();
        $data['title'] = 'Список концертов';
        $obj = new \Model\Concert($app['dbh']);
        $data['concerts'] = $obj->getFutureConcerts();
        
        return $app['twig']->render('index.html.twig', $data);
    }
}
