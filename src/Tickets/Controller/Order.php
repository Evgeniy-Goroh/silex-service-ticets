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
           
           if(!$order = $app['session']->get('order')){
           	   $order = new \Entity\Order(array('concert_id'=>$data['concert']->getId()));
           };
           
           if($mail) {
               $order->setEmail($mail);
           }
           
           $res = $order->save($app['dbh']);
           if ($res) {
           	   $data['result'] = 'Заявка успешно сохранена. У вас есть 1 час чтобы оплатить её!';
           } else {
           	   $data['result'] ='Возникла ошибка при сохранении заказа, возможно выбранное место уже занято.Попробуйте <a href="/">заново</a>';
           }
       }
       
       return $app['twig']->render('order.html.twig', $data);
    }
}
