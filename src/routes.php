<?php 
require __DIR__.'/Tickets/Entity/User.php';
require __DIR__.'/Tickets/Controller/IndexController.php';

$statement = $conn->query('SELECT * FROM users');
while($row = $statement->fetchAll(PDO::FETCH_CLASS, "Tickets\Entity\User")) {
	
	echo $row[0]->getId();
	echo $row[0]->getName();
	echo $row[0]->getMail();
}


// Register routes.
// main page
$app->get('/', 'Tickets\Controller\IndexController::indexAction')
->bind('homepage');


//test page
$app->get('/test', 'Tickets\Controller\TestController::testAction')
	->bind('test');


	
?>