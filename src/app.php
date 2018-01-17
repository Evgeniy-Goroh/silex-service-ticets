<?php 

//twig
$app->register(new \Silex\Provider\TwigServiceProvider(), array(
		'twig.path' => __DIR__ . '/../app/Resources/views'
));

?>