<?php 

try {
    $app['dbh'] = new \PDO('mysql:host='.$app['db.options']['host'].';dbname='.$app['db.options']['name'], 
            $app['db.options']['user'], 
            $app['db.options']['password'], 
            array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
    
} catch (PDOException $e) {
    echo "Err: " . $e->getMessage();
}

