<?php 

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class TicketController
{

    public function indexAction(Request $request, Application $app)
    {
    	$data = array();
    	$id = $request->attributes->get('id');
    	$seat = $request->request->get('seat');
    	
    	if (!$id) {
    		$app->abort(404, 'The requested Concerts was not found.');
    	}else {
    		$obj = new \Model\Concert($app['dbh']);
    		
    		$data['concert'] = $obj->openById($id);
    		$data['title'] = 'Покупка билетов на концерт: '.$data['concert']->getTitle();
    		$data['price'] = $obj->getPrices($id);	
    	}
    	
    	foreach ($seat as $row => $st) {
    		$sum[$row] = $obj->priceByRow($data['price'],$row);
    		$sum[$row]['col'] = count($seat[$row]);
    		$sum[$row]['sum'] = $sum[$row]['price'] * count($seat[$row]);
    	}

    	$data['row'] = $sum;
    	unset($sum);
    	
        
        return $app['twig']->render('ticket.html.twig', $data);
    }
}
