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
$app['security.users'] = array( 'gorokh@retailcrm.ru' => array( 'ROLE_ADMIN', 'password' ) );

