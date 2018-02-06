<?php 
require __DIR__.'/Tickets/Entity/User.php';
require __DIR__.'/Tickets/Controller/IndexController.php';
require __DIR__.'/Tickets/Controller/TestController.php';
require __DIR__.'/Tickets/Controller/TicketController.php';
require __DIR__.'/Tickets/Controller/UserController.php';
require __DIR__.'/Tickets/Controller/Concerts.php';


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

//$app['monolog']->debug('Testing the Monolog logging.');

// main page
$app->get('/', 'Tickets\Controller\IndexController::indexAction')->bind('homepage');

//form buy tickets
$app->get('/ticket', 'Tickets\Controller\TicketController::indexAction')->bind('ticket');

//test page
$app->get('/test', 'Tickets\Controller\TestController::indexAction')->bind('test');

//admin page
$app->get('/admin', 'Tickets\Controller\AdminController::indexAction')->bind('admin');

//concerts page
$app->match('/concerts/{id}', 'Tickets\Controller\Concerts::indexAction')->bind('concerts');

//auth
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
});

?>