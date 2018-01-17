<?php
// Cache
$app['cache.path'] = __DIR__ . '/../cache';

// Twig cache
$app['twig.options.cache'] = $app['cache.path'] . '/twig';

// Emails
$app['admin_email'] = 'gorokh@retailcrm.ru';
$app['site_email'] = 'gorokh@retailcrm.ru';

//db
$app['db.options'] = array(
		'driver'   => 'pdo_mysql',
		'host'     => 'localhost',
		'port'     => '',
		'dbname'   => 'db_tickets_silex',
		'user'     => 'root',
		'password' => '123456',
);
