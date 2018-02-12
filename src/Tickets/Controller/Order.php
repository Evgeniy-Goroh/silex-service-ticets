<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
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
       
       $order = $app['session']->get('order');
       
       if($mail) {
       	    $order->setEmail($mail);
       	    die('stop');
       	    $order->save($app['dbh']);
       	    echo 'заявка сохранена';
       }
       
       //
       $errors = $app['validator']->validate($mail, new Assert\NotBlank());
       if (count($errors) > 0) {
       	   $data['errors'] = (string) $errors;
       	   return $app->redirect('/ticket/'.$id);
       }
       
       
       return $app['twig']->render('order.html.twig', $data);
    }
}
