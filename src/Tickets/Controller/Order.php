<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Order
{
    public function indexAction(Request $request, Application $app)
    {
       $data = array();
       $id = $request->attributes->get('id');
       $mail = $request->request->get('Email');
       if (!$id) {
           $app->abort(404, 'The requested Concerts was not found.');
       }else {
           $obj = new \Model\Concert($app['dbh']);
           $data['concert'] = $obj->openById($id); 
       }
       
       
       
       
       var_dump($id);
       var_dump($request->request);
       
       
       return $app['twig']->render('order.html.twig', $data);
    }
}
