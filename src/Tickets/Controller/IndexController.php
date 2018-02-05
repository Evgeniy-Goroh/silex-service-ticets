<?php

namespace Tickets\Controller;

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
        
        echo '<pre>';
        foreach($data['concerts'] as $concert) {
            //var_dump($concert->getId());
            //var_dump($concert->getTitle());
            //var_dump($concert->getPrices());
            //var_dump($concert);
        }
        echo '</pre>';
      
        
        
        return $app['twig']->render('index.html.twig', $data);
    }
}
