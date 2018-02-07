<?php 

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class TestController
{

    public function indexAction(Request $request, Application $app)
    {
        $data = array('name' => 'test page');
        
        return $app['twig']->render('test.html.twig', $data);
    }
}
