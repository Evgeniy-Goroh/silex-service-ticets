<?php 

require __DIR__.'/Tickets/Model/Base.php';
require __DIR__.'/Tickets/Model/UserProvider.php';



$app->register(new Silex\Provider\HttpCacheServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\RoutingServiceProvider());

//twig
$app->register(new \Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__ . '/../app/Resources/views'
));


// Security definition.
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
	'security.firewalls' => array(
			// Login URL is open to everybody.
			'login' => array(
					'pattern' => '^/user/login$',
					'anonymous' => true,
			),
			// Any other URL requires auth.
			'site' => array(
					'pattern' => '^/.*$',
					'form'	=> array(
							'login_path'		 => '/user/login',
							'username_parameter' => 'form[username]',
							'password_parameter' => 'form[password]',
					),
					'anonymous' => false,
					'logout'	=> array('logout_path' => '/user/logout'),
					'users' => new Model\UserProvider( $app['db.options']),
			),
	),
));


echo '<pre>';
var_dump($app['controllers_factory']);
echo '</pre>';


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