<?php 

try {
	$conn = new PDO("mysql:host=".$app['db.options']['host'].";dbname=".$app['db.options']['name'], 
			$app['db.options']['user'], 
			$app['db.options']['password']
		);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo "Err: " . $e->getMessage();
}
