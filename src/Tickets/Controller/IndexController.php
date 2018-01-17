<?php
namespace Tickets\Controller;

use Silex\Application;

class IndexController
{
    public function indexAction(Request $request, Application $app)
    {
       //to do
       
       return $app['twig']->render('index.html.twig', $data);
    }
}
