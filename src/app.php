<?php 

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;

$app->register(new Silex\Provider\HttpCacheServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\RoutingServiceProvider());

//monolog
$app->register(new Silex\Provider\MonologServiceProvider(), array(
		'monolog.logfile' => PATH_ROOT.'/app/log/development.log',
));

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
                        'check_path' => '/admin/login_check',
                ),
                'logout' => array('logout_path' => '/logout'),
        		'users' =>  new Model\UserProvider($app['dbh']),
        )
        ),
    'security.access_rules' => array(
            array('^/admin', 'ROLE_ADMIN'),
            array('^.*$', 'IS_AUTHENTICATED_ANONYMOUSLY')
    )
            
));

$app['security.default_encoder'] = function ($app) {

    return new PlaintextPasswordEncoder();
};



/*
$app->error(function (\Exception $e, Request $request, $code) {
    switch ($code) {
        case 404:
            $message = 'Error 404 requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }
    
    return new Response($message);
});
*/



$app->boot();

require PATH_SRC . '/routes.php';

return $app;
?>