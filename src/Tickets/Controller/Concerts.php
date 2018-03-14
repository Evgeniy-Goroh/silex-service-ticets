<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

class Concerts
{
	
	public function HomePage(Request $request, Application $app)
	{
		$data = array();
		$data['title'] = 'Список концертов';
		$obj = new \Model\Concert($app['dbh']);
		$data['concerts'] = $obj->getFutureConcerts();
		
		return $app['twig']->render('index.html.twig', $data);
	}
	
	public function Hall(Request $request, Application $app)
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
    
    public function Ticket(Request $request, Application $app)
    {
    	$data = array();
    	$id = $request->attributes->get('id');
    	$seat = $request->request->get('seat');
    	
    	if(!$order = $app['session']->get('order')){
    		$order = new \Entity\Order(array('concert_id'=>$data['concert']->getId()));
    	};
    	
    	if (!$id) {
    		$app->abort(404, 'The requested Concerts was not found.');
    	} else {
    		$obj = new \Model\Concert($app['dbh']);
    		
    		$data['concert'] = $obj->openById($id);
    		$data['concert']->getOccupiedSeats($id);
    		$data['title'] = 'Покупка билетов на концерт: '.$data['concert']->getTitle();
    		$obj->getPrices($data['concert']);
    		$data['price'] = $data['concert']->getPrices();
    		
    		$i = 0;
    		$total = 0;
    		
    		foreach ($order->getSeats() as $k=>$ticket) {
    			$data['seat'][$k] = $obj->priceByRow($data['price'],$ticket['row']);
    			$data['seat'][$k]['seat'] = $ticket['seat'];
    			$data['seat'][$k]['row'] = $ticket['row'];
    		}
    		
    		foreach ($data['seat'] as $k=>$ticket) {
    			$i++;
    			$total += $ticket['price'];
    		}
    		$order->setTotal($total);
    		
    		$data['order']['count'] = $i;
    		$data['order']['total'] = $total;
    		
    		$app['session']->set('order', $order);
    	}
    	
    	return $app['twig']->render('ticket.html.twig', $data);
    }
    
}
