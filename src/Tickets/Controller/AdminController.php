<?php 

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class AdminController
{

    public function indexAction(Request $request, Application $app)
    {
        
        $token = $app['security.token_storage']->getToken();
        if (null !== $token) {
            $user = $token->getUser();
        }
        
        $data['name'] = $user->getUserName();
        $data['title'] = 'Админка :: Список заказов';
        $data['orders'] = \Model\Order::getAllOrders($app['dbh']);
        
        return $app['twig']->render('admin/admin.html.twig', $data);
    }
    
    public function editOrder(Request $request, Application $app)
    {
        
        
        $data = array();
        
        return $app['twig']->render('admin/editorder.html.twig', $data);
    }
    
    public function addConcert(Request $request, Application $app)
    {
        
        
        $data = array();
        
        return $app['twig']->render('admin/addconcert.html.twig', $data);
    }
}
