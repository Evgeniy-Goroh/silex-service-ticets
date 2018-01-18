<?php 

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

// include the prod configuration
require __DIR__.'/prod.php';

// enable the debug mode
$app['debug'] = true;
