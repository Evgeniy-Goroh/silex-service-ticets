<?php 

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


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
            $data['concert']->getOccupiedSeats($id);
            $data['title'] = 'Покупка билетов на концерт: '.$data['concert']->getTitle();
            $obj->getPrices($data['concert']);
            $data['price'] = $data['concert']->getPrices();
            
            $order = new \Entity\Order(array('concert_id'=>$data['concert']->getId()));
            $order->setSeats($seat);
            //$order->setConcert($data['concert']);    
        
        }
        $i = 0;
        $total = 0;
        
        foreach ($seat as $row => $val) {
            foreach ($val as $seat => $p) {
                $arData['seat'][] = array('row'=>$row, 'seat'=>$seat);
            }
        }
        
        foreach ($arData['seat'] as $k=>$ticket) {
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
        
        
        echo '<pre>';
        print_r($data);
        print_r($request->request);
        print_r($order);
        echo '</pre>';
        
        
        
        
        
        return $app['twig']->render('ticket.html.twig', $data);
    }
}
