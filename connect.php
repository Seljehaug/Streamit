<?php
// connection data
// $db_host = 'mysql02.uniweb.no';
// $db_database = 'd29718';
// $db_user = 'd29718';
// $db_pass = 'Liverpool0358';
$db_host = 'localhost';
$db_database = 'test';
$db_user = 'root';
$db_pass = '';

//Create connection
try {
	// Try to connect to database called d29718
	$db = new PDO("mysql:host=$db_host;dbname=$db_database;charset=utf8",$db_user, $db_pass);
} catch(PDOException  $e) {
	try {
	// d29718 does not exist --> connect with empty database name.
	$db_database = '';
	$db = new PDO("mysql:host=$db_host;dbname=$db_database;charset=utf8",$db_user, $db_pass);
} catch (PDOException $e) {
	die ("Could not connect: ".$e->getMessage());
}
}
