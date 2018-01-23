<?php 

require __DIR__.'/Tickets/Model/Base.php';
require __DIR__.'/Tickets/Model/UserProvider.php';

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\Twig\RuntimeLoader;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app->register(new Silex\Provider\HttpCacheServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\RoutingServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());

//$app->boot();

//twig
$app->register(new \Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__ . '/../app/Resources/views'
));



//auth
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
'security.firewalls' => array(
		'main' => array(
				'pattern' => '^.*$',
				'anonymous' => true,
				'form' => array(
						'login_path' => '/login',
						'check_path' => '/test/login_check',
						'username_parameter'=> 'form[email]',
						'password_parameter' => 'form[password]',
				),
				'logout' => array('logout_path' => '/logout'),
				'users' => new Model\UserProvider($conn),
				
		)
		),
	'security.access_rules' => array(
			array('^/test', 'ROLE_ADMIN'),
			array('^.*$', 'IS_AUTHENTICATED_ANONYMOUSLY')
	)
		
));

/*
$app->error(function (\Exception $e, Request $request, $code) {
	switch ($code) {
		case 404:
			$message = 'The requested page could not be found.';
			break;
		default:
			$message = 'We are sorry, but something went terribly wrong.';
	}
	
	return new Response($message);
});
*/

require PATH_SRC . '/routes.php';

return $app;
?>