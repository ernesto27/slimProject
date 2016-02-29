<?php 
require_once '../vendor/autoload.php';


$app = new \Slim\Slim();

$app->config(array(
	'debug' => true,
	'mode' => 'development',
));
$app->setName("sectionApi");

// Show api version
$app->get('/', function () use($app) {
	echo json_encode("Api section");
});

$app->run();

?>