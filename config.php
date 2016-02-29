<?php 
session_start();

define("DEV_SERVER", "localhost.com");
define("PREP_SERVER", "preprod.m.ar");
define("PROD_SERVER", "prodserver");

// Set connection DB , depends on enviroment
switch ($_SERVER['SERVER_NAME']) {
	case DEV_SERVER:
		$dbHost = 'localhost';
		$dbUser = 'root';
		$dbPass = '';
		$dbName = '';
		$isDev = true;
		break;
	case PREP_SERVER:
		$dbHost = 'localhost';
		$dbUser = 'root';
		$dbPass = 'prep-pass';
		$dbName = '';
		$isDev  = false;
		break;
	case PROD_SERVER:
		$dbHost = '';
		$dbUser = '';
		$dbPass = '';
		$dbName = '';
		$isDev  = false;
		break;

}


date_default_timezone_set('America/Argentina/Buenos_Aires');
ORM::configure('mysql:host='.$dbHost.';dbname=naranjaview;charset=utf8');
ORM::configure('username', $dbUser);
ORM::configure('password', $dbPass);

if($isDev) ORM::configure('logging', true);

?>