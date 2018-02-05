<?php 
require __DIR__.'/Tickets/Entity/User.php';
require __DIR__.'/Tickets/Controller/IndexController.php';
require __DIR__.'/Tickets/Controller/TestController.php';
require __DIR__.'/Tickets/Controller/TicketController.php';
require __DIR__.'/Tickets/Controller/UserController.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


$statement = $app['dbh']->query('SELECT * FROM users');
while($row = $statement->fetchAll(PDO::FETCH_CLASS, "Tickets\Entity\User")) {
    //echo $row[0]->getId();
    //echo $row[0]->getName();
    //echo $row[0]->getMail();
}

// main page
$app->get('/', 'Tickets\Controller\IndexController::indexAction')
->bind('homepage');

//form buy tickets
$app->get('/ticket', 'Tickets\Controller\TicketController::indexAction')
->bind('ticket');

//test page
$app->get('/test', 'Tickets\Controller\TestController::indexAction')
    ->bind('test');

//admin page
$app->get('/admin', 'Tickets\Controller\AdminController::indexAction')
->bind('admin');


$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
});

    //echo '<pre>';
    //var_dump($app['security.users']);
    //echo '</pre>';
?>