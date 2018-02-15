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
    	$concert = new \Entity\Concert($app['dbh'], array(
    			'title'=>$request->request->get('title'),
    			'description'=>$request->request->get('description'),
    			'time_start'=>$request->request->get('time'),
    			'concert_date'=>$request->request->get('date'),
    			'publish'=>$request->request->get('publish')
    	));
    	
    	// картинка
    	if ($request->files->get('image') !='') {
    		$concert->setUploadedFile($request->files->get('image'));
    	}
    	
    	// цены
    	$prices = $request->request->get('price');
    	if (is_array($prices)) {
    		foreach($prices as $type=>$price) {
    			$concert->addPrice($type, $price, 100);
    		}
    	}
    	
    	if ($prices) {
    		\Model\Concert::save($concert,$app['dbh']);
    		return $app->redirect('/admin');
    	}
    	
        return $app['twig']->render('admin/addconcert.html.twig');
    }
    
    
}
