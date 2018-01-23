<?php

define( 'PATH_ROOT', dirname( __DIR__ ) );
define( 'PATH_VENDOR', PATH_ROOT . '/vendor' );
define( 'PATH_LOG', PATH_ROOT . '/log' );
define( 'PATH_SRC', PATH_ROOT . '/src' );

require_once PATH_VENDOR.'/autoload.php';
require_once PATH_ROOT. '/app/Application.php';

$app = new Silex\Application();

require PATH_ROOT.'/app/config/dev.php';
require PATH_ROOT.'/app/config/connection.php';
require PATH_SRC.'/app.php';

$app->run();
