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
		'host'     => 'localhost',
		'name'   => 'db_tickets_silex',
		'user'     => 'root',
		'password' => '123456',
);

// User
$app['security.users'] = array( 'admin' => array( 'ROLE_ADMIN', 'YXylVBIE3HLEUNQEH5Z5bSua4vpEG0flg2V1OcpWw4wzel1nomjtkoG2XVKpug3R4hD18tI0Uj1r8z/3rXxtNg==' ) );

