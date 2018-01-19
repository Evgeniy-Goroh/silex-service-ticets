<?php 


use Symfony\Component\HttpFoundation\Response;

//twig
$app->register(new \Silex\Provider\TwigServiceProvider(), array(
		'twig.path' => __DIR__ . '/../app/Resources/views'
));



// Register the error handler.
$app->error(function (\Exception $e, $code) use ($app) {
	if ($app['debug']) {
		return;
	}
	switch ($code) {
		case 404:
			$message = 'The requested page could not be found.';
			break;
		default:
			$message = 'We are sorry, but something went terribly wrong.';
	}
	return new Response($message, $code);
});
?>