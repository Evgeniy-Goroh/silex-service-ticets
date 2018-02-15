<?php 

namespace Tickets;

define( 'PATH_ROOT', dirname( __DIR__ ) );

require_once __DIR__.'/../vendor/autoload.php';
require_once PATH_ROOT.'/app/config/dev.php';
require_once PATH_ROOT.'/app/config/connection.php';

$order = new \Model\Order($app['dbh']);
$order->clearOrders($app['dbh']);
