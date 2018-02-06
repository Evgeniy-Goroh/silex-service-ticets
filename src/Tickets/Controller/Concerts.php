<?php

namespace Tickets\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Concerts
{
    public function indexAction(Request $request, Application $app)
    {
       $data = array();
       $id = $request->attributes->get('id');
       if (!$id) {
           $app->abort(404, 'The requested Concerts was not found.');
       }else {
           $obj = new \Model\Concert($app['dbh']);
           $data['concert'] = $obj->openById($id);
           $data['seat'] = $obj->getOccupiedSeats($id);
           $data['price'] = $obj->getPrices($id);
       }
       
       //echo '<pre>';
       //print_r($data);
       //echo '</pre>';
       
       
        return $app['twig']->render('concerts.html.twig', $data);
    }
}
