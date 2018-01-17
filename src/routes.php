<?php 

//main page
$app->get('/', function() use($app) {
	return $app['twig']->render('hello.html.twig', array(
			'name' => 'test test'
	));
});

?>