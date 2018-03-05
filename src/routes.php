<?php 

use Symfony\Component\HttpFoundation\Request;

//$app['monolog']->debug('Testing the Monolog logging.');

// main page
$app->get('/', 'Controller\Concerts::HomePage')->bind('homepage');

//form buy tickets
$app->match('/ticket/{id}', 'Controller\Concerts::Ticket')->bind('ticket');

//admin page
$app->match('/admin', 'Controller\AdminController::indexAction')->bind('admin');

//concerts page
$app->match('/concerts/{id}', 'Controller\Concerts::Hall')->bind('concerts');

$app->match('/order/{id}', 'Controller\Order::indexAction')->bind('order');

$app->match('/admin/addconcert', 'Controller\AdminController::addConcert')->bind('addConcert');

$app->match('/admin/edit/{id}', 'Controller\AdminController::editOrder')->bind('editOrder');

$app->match('/admin/order/{id}', 'Controller\AdminController::modifyOrderAction')->bind('Order');

//auth
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
});

?>