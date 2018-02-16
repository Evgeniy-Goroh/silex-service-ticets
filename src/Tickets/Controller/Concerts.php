<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

class Concerts
{
    public function indexAction(Request $request, Application $app)
    {
       $data = array();
       $id = $request->attributes->get('id');
       $seat = $request->request->get('seat');
       $stage = $request->request->get('stage');
       
       if (!$id) {
           $app->abort(404, 'The requested Concerts was not found.');
       } else {
           $obj = new \Model\Concert($app['dbh']);
           $data['concert'] = $obj->openById($id);
           $data['seat'] = $data['concert']->getOccupiedSeats($id);
           $obj->getPrices($data['concert']);
           $data['price'] = $data['concert']->getPrices();
           if($stage == 1) {
               $order = new \Entity\Order(array('concert_id'=>$data['concert']->getId()));
               $order->setSeats($seat);
               
               $validator = Validation::createValidatorBuilder()
                   ->addMethodMapping('loadValidatorMetadata')
                   ->getValidator();
               $errors = $validator->validate($order, null, array('save'));
               
               if (!count($errors)) {
                   $app['session']->set('order', $order);
                      return $app->redirect('/ticket/'.$id );
               } else {
                      $data['errors'] = $errors;
               }
           } 
       }
       
       return $app['twig']->render('concerts.html.twig', $data);
    }
    
    
    
}
