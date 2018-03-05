<?php 

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AdminController
{

    public function indexAction(Request $request, Application $app)
    {
    	$obUser = $this->getUser($app);
    	$data['name'] = $obUser->getUserName();
        $data['title'] = 'Админка :: Список заказов';
        $data['orders'] = \Model\Order::getAllOrders($app['dbh']);
        $data['success'] = $app['session']->get('success');
        $data['errors'] = $app['session']->get('error');
        
        
        return $app['twig']->render('admin/admin.html.twig', $data);
    }
    
    public function editOrder(Request $request, Application $app)
    {
    	$id = $request->attributes->get('id');
    	$obUser = $this->getUser($app);
    	$data['name'] = $obUser->getUserName();
    	$data['title'] = 'Редактирование заказа';
    	$data['order'] = \Entity\Order::openById($id, $app['dbh']);
    	
    	if (!$data['order']) {
    		header("Location: /admin");
    		exit;
    	}
    	
        return $app['twig']->render('admin/editorder.html.twig', $data);
    }
    
    public  static function getUser(Application $app)
    {
    	$token = $app['security.token_storage']->getToken();
    	if (null !== $token) {
    		$user = $token->getUser();
    	}
    	
    	return $user;
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
    
    public function modifyOrderAction(Request $request, Application $app)
    {
    	$id = $request->request->get('id');
    	$order = \Entity\Order::openById($id, $app['dbh']);
    	
    	$order->setIsActive($request->request->get('active'));
    	$order->setIsPaid($request->request->get('paid'));
    	
    	if ($order->save($app['dbh'])) {
    		$app['session']->set('success', 'Заявка успешно сохранена');
    	} else {
    		$app['session']->set('error', 'Ошибка при сохранеии заявки');
    	}
    	
    	header("Location: /admin");
    	exit;
    }
}
