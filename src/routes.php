<?php 

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

//$app['monolog']->debug('Testing the Monolog logging.');

// main page
$app->get('/', 'Controller\IndexController::indexAction')->bind('homepage');

//form buy tickets
$app->match('/ticket/{id}', 'Controller\TicketController::indexAction')->bind('ticket');

//test page
$app->get('/test', 'Controller\TestController::indexAction')->bind('test');

//admin page
$app->get('/admin', 'Controller\AdminController::indexAction')->bind('admin');

//concerts page
$app->match('/concerts/{id}', 'Controller\Concerts::indexAction')->bind('concerts');

$app->match('/order/{id}', 'Controller\Order::indexAction')->bind('order');

//auth
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
});

?>